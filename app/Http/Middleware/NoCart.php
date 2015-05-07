<?php namespace App\Http\Middleware;

use Closure,Cart;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NoCart {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$cart = Cart::content();

        if($cart->count(true) == 0) {

            return new RedirectResponse(url('store/view-cart'));

        }

        return $next($request);
	}

}
