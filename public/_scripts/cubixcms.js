/**
 *  CubixCMS Javascript
 *  ------------------------------------
 *  Author:  Sean Pollock
 *  Date:    02/17/2015
 *
 */
(function () {


    var app = angular.module('cubixcms', [], function ($interpolateProvider) {

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

    app.directive('loadCart', function () {

        return {

            restrict: 'A',
            controller: ['$scope', function ($scope) {

                $scope.view_cart();

            }]
        }

    });

    app.directive('rcSubmit', ['$parse', function ($parse) {

        return {
            restrict: 'A',
            require: ['rcSubmit', '?form'],
            controller: ['$scope', function ($scope) {
                this.attempted = false;

                var formController = null;

                this.setAttempted = function () {
                    this.attempted = true;
                };

                this.setFormController = function (controller) {
                    formController = controller;
                };

                this.needsAttention = function (fieldModelController) {
                    if (!formController) return false;

                    if (fieldModelController) {
                        return fieldModelController.$invalid && (fieldModelController.$dirty || this.attempted);
                    } else {
                        return formController && formController.$invalid && (formController.$dirty || this.attempted);
                    }
                };
            }],
            compile: function (cElement, cAttributes, transclude) {
                return {
                    pre: function (scope, formElement, attributes, controllers) {

                        var submitController = controllers[0];
                        var formController = (controllers.length > 1) ? controllers[1] : null;

                        submitController.setFormController(formController);

                        scope.rc = scope.rc || {};
                        scope.rc[attributes.name] = submitController;
                    },
                    post: function (scope, formElement, attributes, controllers) {

                        var submitController = controllers[0];
                        var formController = (controllers.length > 1) ? controllers[1] : null;
                        var fn = $parse(attributes.rcSubmit);

                        formElement.bind('submit', function (event) {
                            submitController.setAttempted();
                            if (!scope.$$phase) scope.$apply();

                            if (!formController.$valid) return false;

                            scope.$apply(function () {
                                fn(scope, {$event: event});
                            });
                        });
                    }
                };
            }
        };

    }]);

    app.directive('backButton', ['$window', function ($window) {

        return {

            restrict: 'A',
            scope: {

                back: '@back'

            },

            link: function (scope, element, attrs) {

                $(element[0]).on('click', function () {

                    $window.history.back();
                    scope.$apply();

                });
            }
        };

    }]);

    app.directive('cbxCreditCardValidation', function () {

        return {

            restrict: 'A',
            link: function (scope, element) {

                element.on('keyup', function (event) {

                    if (Stripe.card.validateCardNumber(element.val())) {

                        $(element).parent().find('span.glyphicon').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                        $(element).parent().parent().removeClass('has-error').addClass('has-success');
                        $(element).parent().parent().find('label > .ccbrand').text(' | Card Brand: ' + Stripe.card.cardType(element.val()));

                    } else {

                        $(element).parent().find('span.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                        $(element).parent().parent().removeClass('has-success').addClass('has-error');
                        $(element).parent().parent().find('label > .ccbrand').text(' | Card Brand: ' + Stripe.card.cardType(element.val()));
                    }

                });

            }

        }

    });

    app.directive('cbxCvcValidation', function () {

        return {

            restrict: 'A',
            link: function (scope, element) {

                element.on('keyup', function (event) {

                    if (Stripe.card.validateCVC(element.val())) {

                        $(element).parent().find('span.glyphicon').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                        $(element).parent().parent().removeClass('has-error').addClass('has-success');

                    } else {

                        $(element).parent().find('span.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                        $(element).parent().parent().removeClass('has-success').addClass('has-error');
                    }

                });

            }

        }

    });

    app.directive('cbxInputValidation', function () {

        return {

            restrict: 'A',
            link: function (scope, element) {

                element.on('keyup', function (event) {

                    if (element.val() !== "") {

                        $(element).parent().find('span.glyphicon').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                        $(element).parent().removeClass('has-error').addClass('has-success');

                    } else {

                        $(element).parent().find('span.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                        $(element).parent().removeClass('has-success').addClass('has-error');

                    }

                });

            }

        }


    });

    app.directive('cbxBanner', function () {

        return {

            restrict: 'AC',
            link: function (scope, elem) {

                var slideNumber = 0,
                    nextSlide = 1,
                    wrapper = $(".cbx-banner"),
                    menu = $(".banner-controls"),
                    slides = $(".slide"),
                    visit_store = $(".visit_store"),
                    totalSlides = slides.length,
                    pauseTime = 4,
                    duration = 1;

                updateSlider = function () {

                    //function that updates navigation
                    slideNumber = t1.currentLabel();

                    if (t1.currentLabel() === slideNumber) {

                        slideNumber = t1.currentLabel();
                        menu.find('input[value="' + slideNumber + '"]').prop('checked', true);

                    }

                };

                repeatSlider = function () {

                    slideNumber = 0;
                    menu.find('input[value="' + slideNumber + '"]').prop('checked', true);

                };

                wrapper.css({'display' : 'block'});

                var t1 = new TimelineMax({onUpdate: updateSlider, onRepeat: repeatSlider});

                for (var i = 0; i < totalSlides; i++) {

                    menu.append('<li style="padding-right: 5px;"><input type="radio" name="banner_ctrl" value="' + i + '"/></li>');

                }


                elem.find('.media-heading').css({'text-shadow': '1px 1px 5px #000'});
                elem.find('img').each(function () {

                    $(this).css({'height': '245px'});

                });

                wrapper.append('<div id="cbx-pause">Paused</div>');
                menu.prepend('<a href="/store/"><i class="fa fa-shopping-cart fa-2x"></i></a>');

                slides.css({'position': 'absolute', 'left': '0px', 'top': '0px'});


                advanceSlide = function () {


                    slides.each(function (slideNumber, totalSlides) {



                        //console.log(slideNumber);
                        $(this).attr('id', 'slide-' + slideNumber);

                        t1.set(".cbx-banner", {visibility: "visible"});
                        if ($(this).hasClass('title')) {

                            t1.addLabel(slideNumber);
                            t1.from($(this).find('img'), duration, {
                                opacity: 0,
                                scale: 0,
                                rotation: 360,
                                ease: Bounce.easeOut
                            });
                        }
                        t1.addLabel(slideNumber);
                        t1.from($(this).find('.media-object'), duration, {opacity: 0, scale: 0, ease: Bounce.easeOut});
                        t1.from($(this).find('.media-heading'), duration, {opacity: 0, scale: 0, ease: Bounce.easeOut});
                        t1.from($(this).find('.media-body p'), duration, {opacity: 0});
                        t1.from($(this).find('.media-body a'), duration, {opacity: 0}, "-=2");


                        if ($(this).hasClass('title')) {

                            t1.to($(this).find('img'), duration + 3, {opacity: 0, scale: 200}, "+=" + pauseTime);

                        } else {

                            t1.to($(this).find('.media-object'), duration, {opacity: 0}, "+=" + pauseTime);

                        }

                        t1.to($(this).find('.media-heading'), duration, {opacity: 0});
                        t1.to($(this).find('.media-body p'), duration, {opacity: 0}, "-=2");
                        t1.to($(this).find('.media-body a'), duration, {opacity: 0}, "-=2");
                        t1.repeat(-1);
                        //console.log($(this).find('.media-object'));


                    });
                    menu.find('input[value="' + slideNumber + '"]').prop('checked', true);

                };

                menu.on('mouseenter', this, function (e) {

                    TweenMax.fromTo(menu, 0.6, {boxShadow: "0px 0px 0px 0px red"},
                        {boxShadow: "0px 0px 20px 2px darkred", repeat: -1, yoyo: true});

                });

                menu.on('mouseleave', this, function (e) {

                    TweenMax.to(menu, 0.6, {boxShadow: "0px 0px 0px 0px yellow"});

                });

                menu.find(':input[type="radio"]').on('mouseenter', this, function (e) {

                    $(this).css('cursor', 'pointer');

                });

                menu.find('a').on('mouseenter', this, function (e) {


                    TweenMax.fromTo($(this).find('i'), 0.5, {rotatation: -10}, {rotation: 10, repeat: -1, yoyo: true});

                });

                menu.find('a').on('mouseleave', this, function (e) {

                    TweenMax.to($(this).find('i'), 0.5, {rotation: 0, repeat: 0})

                });

                slides.on('mouseenter', this, function (e) {


                    //console.log(this);
                    TweenMax.to($("#cbx-pause"), 0.5, {top: 0, ease: Bounce.easeOut});
                    t1.pause();

                });

                slides.on('mouseleave', this, function (e) {


                    //console.log(this);
                    TweenMax.to($("#cbx-pause"), 0.5, {top: -30});
                    t1.play();

                });


                menu.find('li input').each(function () {

                    $(this).on('click', this, function () {

                        //console.log($(this).text());
                        //console.log(t1.currentLabel());

                        t1.seek($(this).attr('value'));
                    });


                });

                // run slides
                advanceSlide();

            }
        };

    });

    app.controller('webpaymentController', ['$scope', '$http', function ($scope, $http) {

        //alert('welcome');
        $scope.session.email = "";
        $scope.session.url = "";
        $scope.ui = {};
        $scope.ui.paybutton = "Pay Now";

        $scope.paynow = function () {

            if ($("#credit_card").length) {


                //alert('ok');
                $("#paybutton").attr('disabled', 'disabled');
                $scope.ui.paybutton = "Processing...";
                Stripe.setPublishableKey('pk_test_0lXr7TO41jgQihh4MtyuqZpO');

                Stripe.card.createToken({
                    name: $("#name").val(),
                    address_line1: $("#address_line1").val(),
                    address_line2: $("#address_line2").val(),
                    address_city: $("#city").val(),
                    address_state: $("#state").val(),
                    address_zip: $("#zip_code").val(),
                    number: $('#credit_card').val(),
                    cvc: $('#cvc').val(),
                    exp_month: $('#exp-month').val(),
                    exp_year: $('#exp-year').find('option:selected').text()

                }, $scope.stripeResponseHandler);
            } else {

                /*
                 * TODO: Processes payment if customer card is already on file.
                 */

                //console.log($form);
                $("#paybutton").attr('disabled', 'disabled');
                $scope.ui.paybutton = "Processing...";

                $http({

                    method: 'post',
                    url: $('#webpayment_form').attr('action'),
                    data: {

                        'cardonfile': true,
                        '_token': $('#_token').val(),
                        'webpayments_token': $("#webpayments_token").val(),
                        'amount': $("#amount").val()

                    }

                }).success(function (data, status, headers, config) {

                    $scope.session.email = data.email;
                    //console.log($scope);
                    $('#webpayment_wizard').wizard('next');

                }).error(function (data, status, headers, config) {

                    $scope.ui.paybutton = "Pay Now";
                    $("#paybutton").removeAttr('disabled');
                    alert('Error with processing payment.')
                });

            }

        };

        $scope.stripeResponseHandler = function (status, response) {

            //console.log(response);
            var $form = $("#webpayment_form");
            $scope.ui.paybutton = "Pay Now";
            if (response.error) {

                $form.find('.payment-errors').text(response.error.message).css('display', 'block');
                $scope.ui.paybutton = "Pay Now";
                $("#paybutton").removeAttr('disabled');


            } else {

                var token = response.id;
                $form.find('.payment-errors').text('').css('display', 'none');
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                $http({

                    method: 'post',
                    url: $('#webpayment_form').attr('action'),
                    data: {

                        '_token': $('#_token').val(),
                        'stripeToken': token,
                        'webpayments_token': $("#webpayments_token").val(),
                        'amount': $("#amount").val()
                    }

                }).success(function (data, status, headers, config) {

                    //console.log(data.card_error);
                    $scope.ui.paybutton = 'Pay Now';
                    $("#paybutton").removeAttr('disabled');

                    if (data.card_error) {

                        $form.find('.payment-errors').text(data.card_error.message).css('display', 'block');
                        $scope.ui.paybutton = "Pay Now";
                        $("#paybutton").removeAttr('disabled');


                    } else if (data.status === 'unsuccessful') {

                        $form.find('.payment-errors').text('There was an issue with your card.  Please contact your bank or financial institution for assistance.').css('display', 'block');
                        $scope.ui.paybutton = "Pay Now";
                        $("#paybutton").removeAttr('disabled');


                    } else if (data.exception) {

                        $form.find('.payment-errors').text(data.exception).css('display', 'block');
                        $scope.ui.paybutton = "Pay Now";
                        $("#paybutton").removeAttr('disabled');


                    } else {

                        //$scope.confirmation_code = data.confirmation_code;
                        //alert('Confirmation Code: ' + data.confirmation_code);
                        $scope.session.email = data.email;
                        //console.log($scope);
                        $scope.ui.paybutton = "Pay Now";
                        $("#paybutton").removeAttr('disabled');
                        $('#webpayment_wizard').wizard('next');

                    }

                }).error(function (data, status, headers, config) {

                    $("#paybutton").removeAttr('disabled');
                    $scope.ui.paybutton = "Pay Now";
                    alert('error');

                });


            }


        };

        $scope.next = function () {

            $("#webpayment_wizard").wizard('next');


        };

        $scope.prev = function () {

            $("#webpayment_wizard").wizard('previous');

        };


    }]);

    app.controller('shoppingCart', ['$scope', '$http', function ($scope, $http, $localStorage, $sessionStorage, ngProgress) {

        $('[data-toggle="popover"]').popover();

        $('.description').ThreeDots({max_rows: 4});

        $scope.session = {};
        $scope.cart = {};
        $scope.cart.subtotal = 0.00;
        $scope.cart_count = 0;
        $scope.isRemoved = false;
        $scope.isRelatedProduct = true;

        $http({
            method: 'GET',
            url: '/store/refresh-cart'
        }).success(function (data, status, headers, config) {


            $scope.cart = data.cart;
            $scope.cart_total = data.total;
            $scope.cart_count = data.count;
            //sessionStorage.setItem("cart",JSON.stringify(data.cart));
            //sessionStorage.setItem("cart_count",data.cart_count);

            //$scope.cart = JSON.parse(sessionStorage.getItem("cart"));
            //$scope.cart = 0;

            //localStorage.setItem("cart_count",data.count);
            //localStorage.setItem("cart_total",data.total);

            //console.log(localStorage.getItem("cart"));
            //console.log($scope.$cart);

        }).error(function (data, status, headers, config) {

            if (status == '404') {

                //alert('Page Not Found');

            }

        });


        $scope.changeQty = function ($indicator, $rowid) {

            //alert($indicator);

            $http({

                method: 'POST',
                url: '/store/change-qty',
                data: {

                    'rowid': $rowid,
                    'qty': $indicator
                }

            }).success(function (data, status, headers, config) {


                $scope.cart = data.cart;
                $scope.cart_count = data.count;
                $scope.cart_total = data.subtotal;
                //alert($localStorage.message);
                if ($indicator == 0) {

                    $.growl({

                        title: ' <strong>Shopping Cart</strong>',
                        message: '<p>Item <code>' + data.sku + '</code> has been removed from shopping cart</p>'

                    }, {

                        type: 'info',
                        offset: {
                            x: 20,
                            y: 70

                        },
                        placement: {

                            align: 'right'
                        }

                    });


                } else {

                    $.growl({

                        title: ' <strong>Shopping Cart</strong>',
                        message: '<p>Shopping cart has been updated</p>'

                    }, {

                        type: 'info',
                        offset: {
                            x: 20,
                            y: 70

                        },
                        placement: {

                            align: 'right'
                        }

                    });
                }

            }).error(function (data, status, headers, config) {

                $.growl({

                    title: ' <strong>Error</strong>',
                    message: '<p>Failed updating shopping cart.</p>'

                }, {

                    type: 'danger',
                    offset: {
                        x: 20,
                        y: 70

                    },
                    placement: {

                        align: 'right'

                    }

                });

            });

        };


        $scope.update = function ($prod_id) {


            var link;

            if (!$prod_id) {

                link = "/store/update";

            }

            if ($("#" + 'addToCart_form').length > 0)

                var link = $("#addToCart_form").attr("action") + "/" + $prod_id;

            if ($("#" + 'qty_form').length > 0)

                var link = $("#qty_form").attr("action") + "/" + $prod_id;


            //alert($localStorage.message);

            $http({

                method: 'POST',
                url: link

            }).success(function (data, status, headers, config) {

                $scope.cart = data.cart;
                $scope.cart.subtotal = data.subtotal;
                $scope.isRelatedProduct = false;
                $scope.cart_count = data.count;

                $.growl({

                    title: '<strong>Shopping Cart</strong>',
                    message: '<p>Item <code>' + data.sku + '</code> has been saved to shopping cart</p>'

                }, {

                    type: 'info',
                    offset: {
                        x: 20,
                        y: 70

                    },
                    placement: {

                        align: 'right'

                    }

                });

                //console.log($scope.cart.count);


            }).error(function (data, status, headers, config) {

                $.growl({

                    title: '<strong>Error</strong>',
                    message: '<p>Failed adding item to shopping cart.</p>'

                }, {

                    type: 'danger',
                    offset: {
                        x: 20,
                        y: 70

                    },
                    placement: {

                        align: 'right'
                    }

                });

            });


        };

        $scope.guest_checkout = function () {

            // TODO: Guest Checkout function

            alert('Feature not available!');

        };

        $scope.login = function () {

            // TODO:  Login function

            alert('logged in!');

        };

        $scope.create_account = function () {

            // TODO: Account creation function
            //alert($scope.session.name);
            $scope.session.error = {};
            $http({

                method: 'POST',
                url: '/store/create-account',
                data: {

                    'name': $scope.session.name,
                    'email': $scope.session.email,
                    'password': $scope.session.password,
                    'password_confirmation': $scope.session.password_confirmation

                }

            }).success(function (data, status, headers, config) {

                alert(data.msg);
                $scope.session.loggedin = true;

            }).error(function (data, status, headers, config) {

                //alert(status);
                switch (status) {

                    case 422:

                        $scope.session.error = data;
                        console.log($scope.session.error);

                        break;

                    case 404:

                        alert('404 Page Not Found!');
                        break;

                    default:

                        window.location.href = "/store/view-cart";
                        break;

                }

            });

        };

        $scope.placeOrder = function () {


        };


    }]);

}(jQuery));