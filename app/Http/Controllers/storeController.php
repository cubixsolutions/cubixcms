<?php  namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductType;
use App\User;

use Cart,Hash,Mail,Auth,Validator;

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

    public function category(ProductCategory $category)
    {

        if($category->slug) {

            $products = Product::whereCategory_id($category->id)->paginate(8);

            if ( view()->exists('store.products') ) {

                return view('store.products', array('category' => $category->category, 'products' => $products));

            } else {

                abort(404);
            }

        } else {

            abort(404);

        }

    }

    public function refreshCart() {

        $cart = Cart::content();
        $subtotal = Cart::total();
        $count = Cart::count();

        return response()->json(['cart' => $cart, 'subtotal' => $subtotal, 'count' => $count]);

    }

}