<?php  namespace App\Http\Controllers; 

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


        if(view()->exists($page)) {

            return view($page);

        } else {

            abort(404);

        }

    }


}