<?php  namespace App\Http\Controllers;

use App\Commands\CreateUserAccount;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductType;
use App\User;

use Cart,Hash,Mail,Auth,Validator,Request;

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

    public function changeItemQty() {

        $rowid = Request::input('rowid');
        $cartItem = Cart::get($rowid);
        $sku = $cartItem->id;
        $qty = Request::input('qty');

        if ($qty > 0) {

            Cart::update($rowid, array('qty' => $qty));

        } elseif($qty <= 0) {

            Cart::remove($rowid);

        }

        $cart = Cart::content();

        return response()->json(['sku' => $sku, 'cart' => $cart, 'count' => Cart::count(), 'subtotal' => Cart::total()]);

    }

    public function removeCart() {

        $rowid = Request::input('rowid');
        $cartItem = Cart::get($rowid);
        $sku = $cartItem->id;

        Cart::remove($rowid);
        $cart = Cart::content();

        return response()->json(['sku' => $sku, 'cart' => $cart, 'count' => Cart::count(), 'subtotal' => Cart::total()]);


    }

    public function addCart($id) {

        $product = Product::find($id);

        $sku = $product->sku;
        $name = $product->product;
        $price = $product->price;

        Cart::associate('Product','App')->add($sku,$name, 1, $price);

        $cart = Cart::content();

        return response()->json(['sku' => $sku, 'cart' => $cart, 'count' => Cart::count(), 'subtotal' => Cart::total()]);

    }

    public function viewCart() {

        $cart = Cart::content();

        if (view()->exists('store.cart')) {

            return view('store.cart', array('cart'  => $cart));

        } else {

            abort(404);

        }

    }

    public function refreshCart() {

        $cart = Cart::content();
        $total = Cart::total();
        $count = Cart::count();

        //$mycart = json_decode(json_encode($cart), true);
        return response()->json(['cart' => $cart, 'total' => $total, 'count' => $count]);

    }

    public function updateCart(Request $request) {

        $cart = Cart::content();

        $rowId = $request->input('rowId');
        $qty = $request->input('qty');

        if($qty == 0) {

            Cart::remove($rowId);

        } else {

            Cart::update($rowId, array('qty' => $qty));

        }

        $subtotal = Cart::total();

        return response()->json(['msg' => 'Shopping Cart Updated!', 'subtotal' => $subtotal]);

    }

    public function checkout() {

        // TODO: make checkout routine

        $cart = Cart::content();
        $recommended_products = array();

        $related_product_counter = 0;

        foreach($cart as $row) {

            $product = Product::wheresku($row->id)->first();
            $related_product = $product->hasRelatedProduct;

            foreach($related_product as $prod) {

                if(Cart::search(array('id' => $prod->sku)) == false) {

                    if($related_product_counter != $prod->id) {

                        $related_product_counter = $prod->id;
                        $recommended_products[] = collect(['id'         => $prod->id,
                                                           'image'      => $prod->image,
                                                           'sku'        => $prod->sku,
                                                           'product'    => $prod->product,
                                                           'description' => $prod->description,
                                                           'price'       => $prod->price]);

                    }

                }

            }

        }

        if(view()->exists('store.checkout')) {

            if (Auth::check() && $related_product->count > 0) {

                return view('store.checkout', array('cart' => $cart, 'recommended' => (empty($recommended_products) ? false : $recommended_products), 'isRelatedProduct' => $related_product));

            } else {

                return view('store.checkout', array('cart' => $cart, 'recommended' => (empty($recommended_products) ? false : $recommended_products), 'isRelatedProduct' => $related_product));

            }

        } else {

            abort('404');
        }

    }

    public function createAccount(Requests\StoreUserCreateRequest $request) {

        // TODO:  Create Account function
        $name = Request::input('name');
        $email = Request::input('email');
        $password = Request::input('password');

        $this->dispatch(new CreateUserAccount($name,$email,$password));

        if (Auth::attempt(['email' => $email, 'password' => $password]) ) {

            return response()->json(['msg' => 'Account Logged In!']);

        }

    }

}