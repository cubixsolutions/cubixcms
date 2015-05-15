/**
 *  CubixCMS Javascript
 *  ------------------------------------
 *  Author:  Sean Pollock
 *  Date:    02/17/2015
 *
 */
(function() {



    var app = angular.module('cubixcms', ['ngProgress','ngStorage','angularPayments'],function($interpolateProvider) {

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

    app.directive('loadCart', function() {

        return {

            restrict: 'A',
            controller: ['$scope', function ($scope) {

                $scope.view_cart();

            }]
        }

    });

    app.directive('rcSubmit', ['$parse', function($parse) {

            return {
                restrict: 'A',
                require: ['rcSubmit', '?form'],
                controller: ['$scope', function ($scope) {
                    this.attempted = false;

                    var formController = null;

                    this.setAttempted = function() {
                        this.attempted = true;
                    };

                    this.setFormController = function(controller) {
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
                compile: function(cElement, cAttributes, transclude) {
                    return {
                        pre: function(scope, formElement, attributes, controllers) {

                            var submitController = controllers[0];
                            var formController = (controllers.length > 1) ? controllers[1] : null;

                            submitController.setFormController(formController);

                            scope.rc = scope.rc || {};
                            scope.rc[attributes.name] = submitController;
                        },
                        post: function(scope, formElement, attributes, controllers) {

                            var submitController = controllers[0];
                            var formController = (controllers.length > 1) ? controllers[1] : null;
                            var fn = $parse(attributes.rcSubmit);

                            formElement.bind('submit', function (event) {
                                submitController.setAttempted();
                                if (!scope.$$phase) scope.$apply();

                                if (!formController.$valid) return false;

                                scope.$apply(function() {
                                    fn(scope, {$event:event});
                                });
                            });
                        }
                    };
                }
            };

    }]);

    app.directive('backButton', ['$window', function($window) {

       return {

           restrict: 'A',
           scope: {

               back: '@back'

           },

           link: function(scope, element, attrs) {

               $(element[0]).on('click', function() {

                    $window.history.back();
                    scope.$apply();

               });
           }
       };

    }]);

    app.directive('cbxCreditCardValidation', function() {

        return {

            restrict: 'A',
            link: function(scope,element) {

                element.on('keyup', function(event) {

                    if(Stripe.card.validateCardNumber(element.val())) {

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

    app.directive('cbxCvcValidation', function() {

        return {

            restrict: 'A',
            link: function(scope,element) {

                element.on('keyup', function(event) {

                    if(Stripe.card.validateCVC(element.val())) {

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

    app.controller('webpaymentController', ['$scope', '$http', function($scope,$http) {

        //alert('welcome');

        $scope.paynow = function() {

           if ($("#credit_card").length) {


               //alert('ok');
               $("#paybutton").attr('disabled','disabled');
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

               var $form = $("#webpayment_form");
               $form.get(0).submit();

           }

        };

        $scope.stripeResponseHandler = function(status, response) {

            console.log(response);
            var $form = $("#webpayment_form");

            if (response.error) {

                $form.find('.payment-errors').text(response.error.message).css('display','block');
                $("#paybutton").removeAttr('disabled');

            } else {

                var token = response.id;
                $form.find('.payment-errors').text('').css('display','none');
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                $http({

                    method: 'post',
                    url: $('#webpayment_form').attr('action'),
                    data: {

                        '_token' : $('#_token').val(),
                        'stripeToken' : token,
                        'webpayments_token' : $("#webpayments_token").val(),
                        'amount' : $("#amount").val()
                    }

                }).success(function (data, status, headers, config) {

                    $('#webpayment_wizard').wizard('next');
                    alert(data.status);
                    console.log(data.change);

                }).error(function (data, status, headers, config) {

                  alert('error');

                });


                //$form.get(0).submit();

            }


        };

        $scope.next = function() {

           $("#webpayment_wizard").wizard('next');


        };

        $scope.prev = function() {

            $("#webpayment_wizard").wizard('previous');

        };


    }]);

    app.controller('shoppingCart', ['$scope', '$http', function($scope, $http, $localStorage, $sessionStorage, ngProgress) {

        $('[data-toggle="popover"]').popover();

        $('.description').ThreeDots({max_rows:4});

        $scope.session = {};
        $scope.cart = {};
        $scope.cart.subtotal = 0.00
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


        $scope.changeQty = function($indicator,$rowid) {

            //alert($indicator);

            $http({

                method: 'POST',
                url: '/store/change-qty',
                data: {

                    'rowid' : $rowid,
                    'qty'   : $indicator
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


        $scope.update = function($prod_id) {


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

        $scope.guest_checkout = function() {

          // TODO: Guest Checkout function

            alert('Feature not available!');

        };

        $scope.login = function() {

            // TODO:  Login function

            alert('logged in!');

        };

        $scope.create_account = function() {

         // TODO: Account creation function
            //alert($scope.session.name);
            $scope.session.error = {};
            $http({

                method: 'POST',
                url: '/store/create-account',
                data: {

                    'name'                  : $scope.session.name,
                    'email'                 : $scope.session.email,
                    'password'              : $scope.session.password,
                    'password_confirmation' : $scope.session.password_confirmation

                }

            }).success(function (data, status, headers, config) {

                    alert(data.msg);
                    $scope.session.loggedin = true;

            }).error(function (data, status, headers, config) {

                //alert(status);
                switch(status) {

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

        $scope.placeOrder = function() {




        };




    }]);

}(jQuery));