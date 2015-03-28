/**
 *  CubixCMS Javascript
 *  ------------------------------------
 *  Author:  Sean Pollock
 *  Date:    02/17/2015
 *
 */
(function() {


    var app = angular.module('cubixcms', [],function($interpolateProvider) {

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

    app.controller('shoppingCart', ['$scope', '$http', function($scope,$http) {

        $scope.cart = {};
        $scope.cart.subtotal = '0.00';
        $scope.cart.count = 0;

        $scope.isRelatedProduct = true;

        $scope.update = function($prod_id) {

            var link = $("#addToCart_form").attr("action") + "/" + $prod_id;
            $http({
                method: 'POST',
                url: link
            }).success(function (data, status, headers, config) {

                $scope.cart = data.cart;
                $scope.cart.subtotal = data.subtotal;
                $scope.isRelatedProduct = false;
                $scope.cart.count = data.count;

                $.growl({

                    title: '<strong>Shopping Cart</strong>',
                    message: '<p>Item <code>' + data.sku + '</code> has been saved to shopping cart</p>',

                }, {

                    type: 'info'

                });

                //console.log($scope.cart.count);


            }).error(function (data, status, headers, config) {


            });


        };

        /**
         * function to place order
         */

        $scope.placeOrder = function() {




        };

        $http({
            method: 'GET',
            url: '//localhost:8000/store/refresh-cart'
        }).success(function (data, status, headers, config) {

            //console.log(data.cart);
            $scope.cart = data.cart;
            $scope.cart.subtotal = data.subtotal;
            $scope.cart.count = data.count;
            console.log($scope.cart.count);

        }).error(function (data, status, headers, config) {

            if(status == '404') {

                //alert('Page Not Found');

            }
        });


    }]);


$(document).ready(function () {


    $(".wizard").wizard({

        disablePreviousStep: true

    });

    $(".placard").placard({

        explicit: true,
        revertOnCancel: true,


    });

    $(".jumbotron.active").runAnimatedBanner({

        animation: Elastic.easeOut,
        logo: '/_assets/cubix-solutions_logo.svg',
        logoWidth: '600px',
        logoHeight: 'auto',
        complete: function() {

            this.restart();

        }

    });

    var maxHeight = -1;
    var captcha_success = false;
    var myTween;

    $("#backdrop").hide().fadeIn(3000);

    var currPage = getCurrentPageName();

    $("nav li a").each(function (index, element) {


        if ($(this).attr('href') === currPage) {

            $(this).parent().addClass('active');

        } else {

            $(this).parent().removeClass('active');

        }

    });

    $(".technology_banner img").on('mouseover', this, function (event) {

        /* Act on the event */

        $(this).toggleClass("desaturate");

    });

    $(".technology_banner img").on('mouseout', this, function () {


        $(this).toggleClass('desaturate');


    });

    /*
     $('.store-panel').each(function () {


     maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();

     });

     $('.store-panel').each(function () {

     $(this).height(maxHeight+50);

     });
     */
    $('.store-panel').matchHeight({property: 'min-height'});
    $('.store-panel').find('.thumbnail').matchHeight(true);

    $(".addCartLink").on('click', this, function (e) {

        e.preventDefault();
        //alert('welcome');
        var link = $("#addToCart_form").attr("action") + "/" + $(this).attr('product_id');
        //alert(link);

        var request = $.ajax({

            type: "POST",
            url: link,
            dataType: "json",
            data: {

                '_token': $("input").val()

            }


        });

        request.done(function (msg) {


            $("#cart_count").html(msg.cart_count);

            $.growl({

                title: '<strong>Shopping Cart</strong>',
                message: '<p>Item <code>' + msg.sku + '</code> has been saved to shopping cart</p>',

            }, {

                type: 'info'

            });

        });


    });

    $(".backLink").on('click', this, function (e) {

        e.preventDefault();

        window.history.back();


    });

    $("#checkoutBtn").on('click', this, function (e) {


        e.preventDefault();

        location.href = $(this).attr('href');

    });

    $("#newUserBtn").on('click', this, function (e) {

        e.preventDefault();
        $(this).attr('disabled', 'disabled');
        //alert('button clicked');

        var url = $("#create_account").attr('action');
        var name = $("#create_account").find("#name").val();
        var email = $("#create_account").find("#email").val();
        var password = $("#create_account").find("#password").val();
        var password_confirmation = $("#create_account").find("#password_confirmation").val();
        var captcha = $("#g-recaptcha-response").val();
        //alert(captcha);
        var request = $.ajax({

            type: "post",
            url: url,
            dataType: "json",
            data: {

                'name': name,
                'email': email,
                'password': password,
                'password_confirmation': password_confirmation,
                'g-recaptcha-response': (captcha_success == true ? "no-verify" : captcha),
                '_token': $('[name=_token]').val()

            }


        });

        request.done(function (msg) {


            $.growl({

                title: '<strong>System Message</strong>',
                message: '<p>' + msg.msg + '</p>',

            }, {

                type: 'success',

            });

            $("#newUserBtn").removeAttr('disabled');

            $(".error_validation").detach();
            //$("#create_account").parent().prepend('<div class="alert alert-success">Thank you for registering with us!  We have sent you an email with instructions on activating your account.  Once activated, you may proceed with checkout.</div>');
            $(".wizard").wizard('next');

        });

        request.fail(function (jqXHR, textStatus) {

            //alert(textStatus);
            if (textStatus == "error") {
                var parsed_text = JSON.parse(jqXHR.responseText);
                console.log(parsed_text);
                $("#newUserBtn").removeAttr('disabled');

                $(".error_validation").detach();
                $("#create_account").parent().prepend('<div class="alert alert-danger error_validation"></div>');

                for (var key in parsed_text) {


                    if (parsed_text[key] == 'validation.captcha') {

                        //captcha_success = true;
                        grecaptcha.reset();

                    }

                    if (parsed_text[key] != 'validation.captcha') {

                        if (parsed_text.hasOwnProperty(key)) {

                            $(".error_validation").append("<p>" + parsed_text[key] + "</p>");
                            $("#create_account #" + key).css('border-color', 'rgb(255,0,0)');
                            $("#create_account #" + key).css('color', 'rgb(255,0,0)');
                            grecaptcha.reset();

                        }

                    }
                }

            }


            //alert(error);


        });


    });





    $(".page-footer a").on('mouseenter', this, function (e) {


        TweenLite.to(this, 1, {color: '#F1952E'});

    });

    $(".page-footer a").on('mouseout', this, function (e) {


        TweenLite.to(this, 1, {color: '#1C71A4'});

    });



});


/**
 * function returns the current page name
 * @return {string} [description]
 */

function getCurrentPageName() {

    var pageUrl = document.location.href;
    var pageName = pageUrl.substring(pageUrl.lastIndexOf("/") + 1);
    //var pageName = pageName.substring(0,pageName.lastIndexOf("."));

    if (pageName === "")
        pageName = "/page/home";

    return pageName.toLowerCase();

}

(function ($) {

    $.fn.runAnimatedBanner = function (options) {

        /**
         * AnimatedBanner
         * -------------------------------------
         * This jQuery plugin requires Greensock's library
         * @Description Runs an animated banner
         *
         * @type {TimelineMax}
         */

        var settings = $.extend({

            width: '100%',
            height: '400px',
            logo: null,
            logoWidth: '200px',
            logoHeight: '150px',
            animation: Elastic.easeOut,
            delay: 4.5,
            sequence: null,
            complete : null

        }, options);

        var timeline = new TimelineMax({onComplete:settings.complete});
        CSSPlugin.defaultTransformPerspective = 500;

        if (! $.isFunction(settings.sequence)) {
            timeline.set(this, {width: settings.width, height: settings.height});

            if (settings.logo != null) {

                $(this).find('h1').html('<img src="' + settings.logo + '" width="' + settings.logoWidth + '" height="' + settings.logoHeight + '" />');
                timeline.from($(this).find('h1'), 2, {autoAlpha: 0, display: "none",rotationY: 45, scaleX: 1.0, z: -300});
                //timeline.to($(this).find("#redBox"),1, {attr:{x:-100,y:-50}, ease:Linear.easeNone});
                timeline.to($(this).find('h1'), 2, {autoAlpha: 0,rotationY:-45, scaleX: 1.0, z: 300,delay: 2});

            } else {

                timeline.from($(this).find('h1'), 2, {autoAlpha: 0, rotationY: 45, scaleX: 1.0, z: -300});

            }

            timeline.from($(this).find('h3'), 1.5, {
                autoAlpha: 0,
                rotationY: 25,

                z: -100,
                ease: Power2.easeIn
            }, "-=0.50")
                .to($(this).find('h1'), 2, {y: "-50px"})
                .to($(this).find('h3'), 2, {y: "-50px", autoAlpha: 0, display: "none"});

            $(this).find('.feature').each(function () {

                timeline.from($(this).find('img'), 2, {x: -500, autoAlpha: 0,ease: settings.animation})
                .from($(this).find('.caption'), 2, {x: 500, autoAlpha: 0})
                //timeline.staggerFrom($(this).find('.caption p'), 2, {opacity:0,delay:0.5,ease:Elastic.easeOut,force3D:true}, 0.2);
                .to($(this), 2, {autoAlpha: 0,delay: settings.delay});

            });

            return timeline.play();

        } else {

            settings.sequence.call( this );

        }

    };

}(jQuery));