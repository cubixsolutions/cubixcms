<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComments extends Model {

	//

    public function blog() {

        return $this->hasOne('Blog');

    }
}
