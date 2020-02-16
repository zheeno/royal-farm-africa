<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ExternTransactInitiator;
use App\Wallet; 
use App\Sponsor;
use App\Sponsorship;
use App\SponsorCart;
use App\Notification;
use App\Traits\GlobalTrait;


class RaveController extends Controller
{
    use GlobalTrait;


    // ravePaycheckout
    public function ravePaycheckout(Request $request){
        $request->setMethod('POST');
        $cartData = $this->getCartData();

        $request->request->add([
            'amount' => $cartData['total_cap'],
            'desc' => 'Checkout fee',
            'redirect' => env('APP_URL').'/ravePay/checkoutHandler'
        ]);
        return $this->ravePay($request);
    }

    // ravePay
    public function ravePay(Request $request){
        $curl = curl_init();

        $customer_email = Auth::user()->email;
        $amount = floatval($request->input('amount'));  
        $currency = "NGN";
        $base_string = "0123456789ABCDEFGH_";
        $txref = str_shuffle($base_string); // ensure you generate unique references per transaction.
        $PBFPubKey = env("RAVE_PUBLIC_KEY"); // get your public key from the dashboard.
        $redirect_url = $request->input('redirect')."?_token=".$request->input('_token');
        $payment_plan = null; // this is only required for recurring payments.

        // create a record of the transaction init
        $init = new ExternTransactInitiator();
        $init->user_id = Auth::user()->id;
        $init->local_tran_ref =  $txref;
        $init->extern_tran_ref = null;
        $init->amount = $amount;
        $init->description = $request->input('desc');
        $init->extern_platform = "Flutterwave";
        $init->processed = false;
        $init->successful = false;
        $init->save();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount'=>$amount,
            'customer_email'=>$customer_email,
            'currency'=>$currency,
            'txref'=>$txref,
            'PBFPubKey'=>$PBFPubKey,
            'redirect_url'=>$redirect_url,
        ]),
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
        // there was an error contacting the rave API
        die('Curl returned error: ' . $err);
        }

        $transaction = json_decode($response);

        if(!$transaction->data && !$transaction->data->link){
        // there was an error from the API
        print_r('API returned error: ' . $transaction->message);
        }

        // uncomment out this line if you want to redirect the user to the payment page
        //print_r($transaction->data->message);


        // redirect to page so User can pay
        // uncomment this line to allow the user redirect to the payment page
        return redirect($transaction->data->link);
   
    }

        // ravePayProcHandler => handles transaction proceess response
        public function ravePayProcHandler(Request $request){
            $txref = $request->input('txref');
            $init = ExternTransactInitiator::where("local_tran_ref", $txref)->first();
            // if transaction was initiated from royal farmtech site
            if($init){
                $response = $request->input('resp');
                // $content = $response->getContent();
                $array = json_decode($response, true);
                // return $array;
                if($request->input('cancelled') == null){
                    $responseData = $array["data"]["data"];
                    $txData = $array["tx"];
    
                    $flwref = $request->input('flwref');
                    // check if transaction has been processed locally
                    if(!$init->processed){
                        // confirm if transaction was successful
                        if($responseData["responsemessage"] == 'successful'){
                            // confirm charge code is 00 or 0
                            if($txData['chargeResponseCode'] == '00' || $txData['chargeResponseCode'] == '0'){
                                // confirm currency
                                if($txData['currency'] == 'NGN'){
                                    // confirm amount
                                    if($txData['amount'] >= $init->amount){
                                        // ********************
                                        // give customer value
                                        // ********************
                                        $init->successful = true;
    
                                        $credit = new Wallet();
                                        $credit->user_id = Auth::user()->id;
                                        $credit->amount = $txData['amount'];
                                        $credit->is_credit = true;
                                        $credit->description = "Added funds to your virtual wallet using ".$txData['paymentType'].". Tans Ref.: ".$flwref;
                                        $credit->save();
    
                                        return redirect('/dashboard')->with('success', 'You have successfully added funds to your virtual wallet');
                                        // ********************
                                        // ********************
                                        // ********************
                                    }else{
                                        // invalid amount
                                        $init->successful = false;
                                        return "Invalid amount";
                                    }
                                }else{
                                    // invalid currency
                                    $init->successful = false;
                                    return "Invalid currency";
    
                                }
                            }else{
                                // charge failed
                                $init->successful = false;
                                return "Charge failed";
    
                            }
                        }else{
                            // transaction failed
                            $init->successful = false;
                            return "Transaction failed";
    
                        }
                        $init->extern_tran_ref = $flwref;
                        $init->processed = true;
                        $init->save();
                    }else{
                        // transaction has been processed
                        return "Tranaction processed";
    
                    }
                    // return($response);
                }else{
                    return "transaction cancelled";
                }
            }else{
                // invalid transaction
                return "Invalid transaction";
            }
        }

    // checkoutHandler => handles transaction proceess response
    public function checkoutHandler(Request $request){
        $txref = $request->input('txref');
        $init = ExternTransactInitiator::where("local_tran_ref", $txref)->first();
        // if transaction was initiated from royal farmtech site
        if($init){
            $response = $request->input('resp');
            // $content = $response->getContent();
            $array = json_decode($response, true);
            // return $array;
            if($request->input('cancelled') == null){
                $responseData = $array["data"]["data"];
                $txData = $array["tx"];

                $flwref = $request->input('flwref');
                // check if transaction has been processed locally
                if(!$init->processed){
                    // confirm if transaction was successful
                    if($responseData["responsemessage"] == 'successful'){
                        // confirm charge code is 00 or 0
                        if($txData['chargeResponseCode'] == '00' || $txData['chargeResponseCode'] == '0'){
                            // confirm currency
                            if($txData['currency'] == 'NGN'){
                                // confirm amount
                                if($txData['amount'] >= $init->amount){
                                    // ********************
                                    // give customer value
                                    // ********************
                                    $init->successful = true;
                                    
                                    $cartData = $this->getCartData();
                                    foreach ($cartData['cart_items'] as $key => $item) {
                                        $sponsor = new Sponsor();
                                        $sponsor->user_id = $item->user_id;
                                        $sponsor->sponsorship_id = $item->sponsorship_id;
                                        $sponsor->units = $item->units;
                                        $sponsor->price_per_unit = $item->price_per_unit;
                                        $sponsor->expected_return_pct = $item->expected_return_pct;
                                        $sponsor->total_capital = $item->total_capital;
                                        $sponsor->transaction_id = $txref;
                                        $sponsor->transaction_ref_id = $flwref;
                                        $sponsor->payment_method = $txData['paymentType'];
                                        $sponsor->has_paid = true;
                                        $sponsor->save();
                                        // delete the item from cart
                                        $_sponsor = SponsorCart::find($item->id);
                                        $_sponsor->forceDelete();
                                        // notify user about the entry
                                        $link = "/sponsors/".$sponsor->id;
                                        $message = "Hello ".Auth::user()->name.", we are glad to have you as a sponsor. 
                                        We have received your entry to sponsor ".number_format($item->units)." unit(s) of the <strong><a href='$link'>".$item->sponsorship->title."</a></strong> sponsorship. 
                                        For more information on how to keep track of the progress on the farms, kindly contact our support center.";
                                        $notif = new Notification();
                                        $notif->user_id = Auth::user()->id;
                                        $notif->message = $message;
                                        $notif->link = $link;
                                        $notif->seen = false;
                                        $notif->save();
                                    }
                                    // ********************
                                    // save transaction information
                                    // ********************
                                    $transact = new Wallet();
                                    $transact->user_id = Auth::user()->id;
                                    $transact->amount = $txData['amount'];
                                    $transact->is_credit = false;
                                    $transact->description = "Payment made with Tans Ref.: ".$flwref." as capital for sponsorship";
                                    $transact->save();
                                    // notify the admin panel of the sponsor entry
                                    return redirect("success")
                                    ->with("title", "Weldone!!!")
                                    ->with("message", "Your sponsorship entry has been created successfully")
                                    ->with("link", "/history");
                                    // ********************
                                    // ********************
                                    // ********************
                                }else{
                                    // invalid amount
                                    $init->successful = false;
                                    return "Invalid amount";
                                }
                            }else{
                                // invalid currency
                                $init->successful = false;
                                return "Invalid currency";

                            }
                        }else{
                            // charge failed
                            $init->successful = false;
                            return "Charge failed";

                        }
                    }else{
                        // transaction failed
                        $init->successful = false;
                        return "Transaction failed";

                    }
                    $init->extern_tran_ref = $flwref;
                    $init->processed = true;
                    $init->save();
                }else{
                    // transaction has been processed
                    return "Tranaction processed";

                }
                // return($response);
            }else{
                return "transaction cancelled";
            }
        }else{
            // invalid transaction
            return "Invalid transaction";
        }
    }
}
