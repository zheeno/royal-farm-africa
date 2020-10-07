<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::GET('/', 'GuestController@landing')->name('landing');
Route::GET('/faqs', 'GuestController@faqs')->name('faqs');
Route::GET('/contact', 'GuestController@contact')->name('contact');


Route::group(['middleware' => 'auth'], function(){
    Route::GET('/dashboard', 'HomeController@index')->name('home');

    Route::GET('/history', 'HomeController@getUserSponsorHistory')->name('history');

    Route::GET('/success', 'HomeController@showSuccessPage');

    Route::GET('/profile', 'HomeController@userProfile')->name('profile');

    Route::POST('/profile', 'HomeController@updateUserProfile');

    Route::POST('/changeAvatar', 'HomeController@updateUserAvatar');

    // ravepay group
    Route::group(['prefix' => 'ravePay'], function(){
        Route::POST('/', 'RaveController@ravePay');
        Route::POST('/handler', 'RaveController@ravePayProcHandler');

        Route::POST('/checkout', 'RaveController@ravePaycheckout');
        Route::POST('/checkoutHandler', 'RaveController@checkoutHandler');

    });

    // cart group
    Route::group(['prefix' => 'cart'], function(){
        Route::GET('/', 'HomeController@showCartPage')->name("cart");
        
        Route::POST('/remove', 'HomeController@removeCartItem');

        Route::GET('/checkout', 'HomeController@checkoutCart')->name("cart");
        Route::POST('/checkout', 'HomeController@checkoutCart')->name("cart");

        Route::POST('/checkout/wallet', 'HomeController@checkoutWithWallet');

    });

    // sponsorship group
    Route::group(['prefix' => 'sponsorships'], function(){
        Route::GET('/{id}', 'HomeController@showSingleSponsorship')->name('sponsorships');

        Route::POST('/addReview', 'HomeController@addReview');
    });

    // sponsors group
    Route::group(['prefix' => 'sponsors'], function(){
        Route::POST('/addToCart', 'HomeController@addToSponsorCart');

        Route::POST('/create', 'HomeController@createSponsor');

        Route::GET('/{id}', 'HomeController@openSponsorPage')->name('sponsorships');
    });


    /** 
     * 
     * ADMIN ONLY ROUTES
     * 
     *  **/
    Route::group(['middleware' => 'admin'], function(){
        Route::group(['prefix' => 'cms'], function(){
            Route::GET('/', 'CMSController@dashboard')->name('dashboard');
            Route::GET('/getSponsorsList', 'CMSController@getSponsorsList');
            Route::GET('/getSponsorshipPayoutsData', 'CMSController@getSponsorshipPayoutsData');
            Route::GET('/sponsorsPayoutInitiate', 'CMSController@sponsorsPayoutInitiate');
            
            // categories group
            Route::group(['prefix' => 'categories'], function(){
                Route::GET('/', 'CMSController@showCategories')->name('category');
                Route::POST('/new', 'CMSController@newCategory');
                Route::POST('/update', 'CMSController@updateCategory');
                Route::POST('/delete', 'CMSController@deleteCategory');
                Route::POST('/restore', 'CMSController@restoreCategory');
                Route::GET('/{id}', 'CMSController@openSelectedCategory')->name('category');
                Route::GET('/{cat_id}/{sub_id}', 'CMSController@openSelectedSubCategory')->name('category');
                // subcategories group
                Route::group(['prefix' => 'sub'], function(){
                    Route::POST('/new', 'CMSController@newSubCategory');
                    Route::POST('/update', 'CMSController@updateSubCategory');
                    Route::POST('/delete', 'CMSController@deleteSubCategory');
                    Route::POST('/restore', 'CMSController@restoreSubCategory');
                });
            });

            // sponsorships group
            Route::group(['prefix' => 'sponsorships'], function(){
                Route::POST('/new', 'CMSController@newSponsorship');
                Route::GET('/{id}', 'CMSController@openSponsorshipPage');
                // update setup
                Route::group(['prefix' => 'update'], function(){
                    Route::POST('/status', 'CMSController@updateSponsorshipStatus');

                });
            });

            // pages setup group
            Route::group(['prefix' => 'pages'], function(){
                Route::GET('/faq', 'CMSPagesController@faq')->name('pages.faq');
                Route::POST('/faq', 'CMSPagesController@createFaq')->name('pages.faq.create');
                Route::POST('/faq/update', 'CMSPagesController@updateFaq')->name('pages.faq.update');
                Route::POST('/faq/delete', 'CMSPagesController@deleteFaq')->name('pages.faq.delete');

                Route::GET('/configs', 'CMSPagesController@configs')->name('pages.configs');

            });
        });
    });

});

// sponsorship group for guests
Route::group(['prefix' => 'sponsorships'], function(){
    Route::GET('/', 'GuestController@showSponsorships')->name('sponsorships');
});

Auth::routes();
