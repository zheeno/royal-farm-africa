<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;

    public function category(){
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function sponsorships(){
        return $this->hasMany('App\Sponsorship', 'sub_category_id')->orderBy('id', 'DESC');
    }

    public function active_sponsorships(){
        return $this->hasMany('App\Sponsorship', 'sub_category_id')->where('is_completed', false)->orderBy('id', 'DESC');
    }
}
