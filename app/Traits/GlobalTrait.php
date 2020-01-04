<?php

namespace App\Traits;

use Auth;
use App\Category;
use App\Location;
use App\Sponsor;
use App\Sponsorship;
use App\Subcategory;

trait GlobalTrait
{
    // getSponsoredUnits
    public function getSponsoredUnits($sponsorship){
        // get number of units
        $count = 0;
        foreach ($sponsorship->sponsors as $sponsor) {
            $count += $sponsor->units;
        }
        return $count;
    }

    // getSponsorStats
    public function getSponsorStats(){
        $active_sponsorships = 0;
        $completed_sponsorships = 0;
        $total_units = 0;
        $active_expected_returns = 0;
        $total_profits_made = 0;
        $capital_active_units = 0;
        $capital_all_time = 0;
        $duration = 0;
        // get all sponsor
        $sponsorData = Sponsor::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        // array to keep track of which sposorship entry has been parsed
        $proc_arr = []; $exp_comp_dates = [];
        foreach ($sponsorData as $data) {
            $capital_all_time += $data->total_capital;
            // check if sponsorship is active
            if($data->sponsorship->is_active || $data->sponsorship->in_progress){
                // calculate the active expected returns
                if(!$data->sponsorship->is_completed){
                    $active_sponsorships++;
                    //ensure that the sponsorship has not been parsed
                    if(!$this->array_search($data->sponsorship->id, $proc_arr)){
                        $duration += $data->sponsorship->duration_in_months;
                    }
                    $total_units += $data->units;
                    $capital_active_units += $data->total_capital;
                    $active_expected_returns += $data->expected_return_pct * $data->total_capital;
                }
            }
            // check for completed sponsorships
            if($data->sponsorship->is_completed){
                $completed_sponsorships++;
                /* This may be calculated differently in the 
                future using records from remittance table */

                // get total profits made from completed sponsorships
                $total_profits_made += $data->expected_return_pct * $data->total_capital;
            }
            if(!$this->array_search($data->sponsorship->id, $proc_arr)){
                array_push($proc_arr, $data->sponsorship->id);
            }
            if(!$this->array_search($data->sponsorship->expected_completion_date, $exp_comp_dates)){
                array_push($exp_comp_dates, $data->sponsorship->expected_completion_date);
            }
        }

        return [
            "sponsor_list" => $sponsorData,
            "num_entries" => count($sponsorData),
            "capital_active_units" => $capital_active_units,
            "capital_all_time" => $capital_all_time,
            "maturity_in_months" => $duration,
            "total_active_units" => $total_units,
            "active_sponsorships" => $active_sponsorships,
            "completed_sponsorships" => $completed_sponsorships,
            "active_expected_returns" => $active_expected_returns,
            "total_profits_made" => $total_profits_made,
            "parsed_sponsorship_ids" => $proc_arr,
            "exp_comp_dates" => $exp_comp_dates,
            "high_exp_comp_dates" => $this->array_highest($exp_comp_dates),
        ];
    }

    // search array algorithm
    public function array_search($needle, $haystack){
        if(count($haystack) == 0){
            return false;
        }else{
            // loop through the array 
            for ($i=0; $i < count($haystack); $i++) { 
                if($needle == $haystack[$i]){
                    return true;
                }
            }
            return false;
        }
    }

    // highest value in an array algorithm
    public function array_highest($arr){
        $highest = $arr[0];
        for ($i=0; $i < count($arr); $i++) { 
            if($highest < $arr[$i]){
                $highest = $arr[$i];
            }
        }
        return $highest;
    }
}