<?php  namespace App; 

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {

    protected $table = 'product_categories';

    protected $fillable = ['category'];

    public function products()
    {

        return $this->hasMany('App\Product', 'products');

    }

    public function scopeCategory($query) {

        $query->get('category');

    }

    public function is_category($id)
    {

        if ($this->find($id)) {

            return true;

        } else {

            return false;
        }

    }


}