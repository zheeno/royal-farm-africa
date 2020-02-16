<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    //
    public function subcategories(){
        return $this->hasMany('App\Subcategory', 'category_id')->orderBy('sub_category_name', 'ASC');
    }


    public function sponsorships(){
        return $this->hasMany('App\Sponsorship', 'category_id')->orderBy('id', 'DESC');
    }
}
