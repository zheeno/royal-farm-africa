<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    public function sponsorship(){
        return $this->belongsTo('App\Sponsorship');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
