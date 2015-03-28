<?php  namespace App\Http\Controllers; 

class pageController extends Controller {

    public function __construct() {


    }

    public function index($slug = 'home') {

        $this->page($slug);
    }

    public function page($slug) {

       if(view()->exists($slug)) {

           return view($slug);

       } else {

           abort(404);

       }

    }

}