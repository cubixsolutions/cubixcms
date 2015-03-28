<?php  namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductType;
use App\User;

class storeController extends Controller {

    public function __construct() {


    }

    public function index(ProductCategory $categories)
    {

        $categories = $categories->all();

        if(view()->exists('store.shop')) {

            return view('store.shop', array('categories'    => $categories));

        } else {

            abort(404);

        }

    }

}