<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';

    public function legalEntity()
    {
        return $this->belongsTo('App\legalEntity', 'country_code', 'code');
    }
}
