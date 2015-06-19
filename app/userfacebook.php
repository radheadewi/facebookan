<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class userfacebook extends Model {

	public function user()
    {
        return $this->belongsTo('User');
    }
}