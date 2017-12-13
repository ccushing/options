<?php

namespace options;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';

	#Define a one to many relationship with the user table
    public function user() {
        return $this->belongsTo('\p4\User');
    }


    public static function getContract($contract_id)
    {
    	return \options\Contract::where('contract_id', '=',$contract_id)->get();
    }
}
