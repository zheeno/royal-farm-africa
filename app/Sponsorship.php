<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsorship extends Model
{
    use SoftDeletes;

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne('App\Subcategory', 'id', 'sub_category_id');
    }

    public function sponsors(){
        return $this->hasMany('App\Sponsor');
    }

    public function reviews(){
        return $this->hasMany('App\SponsorshipReview', 'sponsorship_id')->orderBy('id', 'DESC');;
    }
}
