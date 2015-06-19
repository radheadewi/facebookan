<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class profiles extends Model {

	public function profiles()
    {
        return $this->hasMany('Profile');
    }

}
