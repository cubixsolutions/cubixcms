<?php  namespace App\Http\Controllers; 

use App\ProductCategory;

class pageController extends Controller {

    public function __construct() {

        //

    }

    /**
     * @param string $page
     *
     * @return \Illuminate\View\View
     */
    public function index($page = 'home') {

        $category = ProductCategory::all();


        if(view()->exists($page)) {

            return view($page, ['categories' => $category]);

        } else {

            abort(404);

        }

    }


}