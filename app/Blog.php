<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

	//

    protected $table = "blogs";
    protected $fillable = ['user_id,blog_title,blog_text'];


    public function user() {

        return $this->belongsTo('App\User','blogs_user_id_foreign');

    }

    public function comments() {

        return $this->hasMany('App\BlogComments');


    }
}
