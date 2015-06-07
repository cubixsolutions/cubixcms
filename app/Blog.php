<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

	//

    protected $table = "blogs";
    protected $fillable = ['user_id,blog_text'];


    public function comments() {

        return $this->hasMany('App\BlogComments');


    }
}
