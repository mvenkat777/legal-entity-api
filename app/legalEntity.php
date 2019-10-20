<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class legalEntity extends Model
{
	/**
	 * [$table legal_entity in database]
	 * @var string
	 */				
    protected $table = 'legal_entity';

    protected $fillable = ['lei','version','name','country_code','status','validated'];

    /* Each entity has one country */
    public function country()
    {
        return $this->hasOne('App\Country','code','country_code');
    }

    /* Each entity has many history records */
    public function history()
    {
        return $this->hasMany('App\legalEntityHistory','legal_entity_id','id');
    }


}
