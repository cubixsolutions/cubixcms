<?php  namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{

    protected $table = 'products';

    protected $fillable = ['sku','category_id','product','description','price'];

    public function category() {

        return $this->belongsTo('App\ProductCategory');

    }

    public function type() {

        return $this->hasOne('App\ProductType','id','product_type');

    }

    public function has_products($id)
    {

        if($this->find($id)) {

            return true;

        } else {

            return false;

        }

    }

    public function hasRelatedProduct() {

        return $this->belongsToMany('App\Product','related_products','product_id','related_id');

    }

}