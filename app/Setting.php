<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $table = 'settings';

    protected $fillable = ['company','slogan','address1','address2','city','state','postal_code'];


}
