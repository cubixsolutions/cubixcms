
{{--Footer partial--}}

<footer class="page-footer">
	<div class="container">

	<div class="row">
	
		<div class="col-md-2">

			<img src="/_assets/cubix-solutions_logo.svg" />

		</div>

		<div class="col-md-10" style="text-align: right">

			

		</div>	

	</div>

	<div class="row">

		<div class="col-md-12">
		
			<div class="divider"></div>

		</div>

	</div>

	<div class="row">

		<div class="col-md-4">
			
			<h1>Follow us on:</h1>

			<ul id="social-media">
				
				<li><a href="http://www.facebook.com/cubixsolutions"><i class="fa fa-facebook-square fa-3x"></i></a></li>
				<li><a href="http://www.twitter.com/4cubixsolutions"><i class="fa fa-twitter fa-3x"></i></a></li>

			</ul>

			<h1>Help and Support</h1>

			<ul id="bottom-links">
				
				<li><a href="{{url('page','contact-us')}}">Contact Us</a></li>
				<li><a href="{{url('page','privacy-statement')}}">Privacy</a></li>
				<li><a href="{{url('page','security')}}">Security</a></li>

			</ul>

		</div>

		<div class="col-md-4">
		
			<!-- Begin MailChimp Signup Form -->

				
				<style type="text/css">
				
					#mc_embed_signup{background: inherit; clear:left; font:14px Helvetica,Arial,sans-serif; color:#fff;}
					/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   				   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
				
				</style>

				<h1>Subscribe to our Newsletter</h1>
				<p>Get News, Updates, and special offers delivered to your inbox.</p>

				<div id="mc_embed_signup">

					<form action="//cubix-solutions.us3.list-manage.com/subscribe/post?u=a9255c89cc05f7c68c0a41b63&amp;id=3b3ee46834" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    					
    					<div class="form-group">
							
						<input type="email" value="" name="EMAIL" class="email form-control" id="mce-EMAIL" placeholder="email address" required>
    					
    					<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    					
    					</div>

    					<div style="position: absolute; left: -5000px;"><input type="text" name="b_a9255c89cc05f7c68c0a41b63_3b3ee46834" tabindex="-1" value=""></div>
    					
    					<div class="clear">

    						<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary">

    					</div>
  						
					</form>
				</div>

				<!--End mc_embed_signup-->     

		</div>

		<div class="col-md-4">

			<h1>Our Committment to you</h1>
			<p>Our commitment to service excellence is reflected in the pledge we make to our clients and each other to provide and inspire high professional service and to ensure that we deliver outstanding value to our clients.<br /><br />The following <a href="{{url('page','our-pledge')}}">page</a> forms our Service Excellence Pledge and the mission of our firm.</p>

		</div>

	</div>

    <div class="row">

        <div class="container">

            <div id="copyright">

                <p>Copyright &copy; {{date('Y')}} by {{$title}}</p>
                <p>Developed with <a href="https://www.jetbrains.com/phpstorm/">Php<strong>Storm</strong></a> and <a href="http://laravel.com">Laravel 5</a></p>

            </div>

        </div>

    </div>

</div>

</footer>