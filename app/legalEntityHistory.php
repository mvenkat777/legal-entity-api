<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legalEntityHistory extends Model
{
    /**
	 * [$table legal_entity_history in database]
	 * @var string
	 */				
    protected $table = 'legal_entity_history';

    protected $fillable = ['legal_entity_id', 'version', 'name', 'country_code', 'status', 'date_changed'];

    public function legalEntity()
    {
        return $this->belongsTo('App\legalEntity','id','legal_entity_id');
    }

}
