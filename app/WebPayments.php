<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WebPayments extends Model {

    protected $table = "webpayments";

    public function user() {

        return $this->belongsTo('App\User');

    }

}
