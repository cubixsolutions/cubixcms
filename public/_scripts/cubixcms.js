/**
 *  CubixCMS Javascript
 *  ------------------------------------
 *  Author:  Sean Pollock
 *  Date:    02/17/2015
 *
 */
(function() {


    $('[data-toggle="tooltip"]').tooltip();
    var app = angular.module('cubixcms', ['ngProgress'],function($interpolateProvider) {

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

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

    app.controller('shoppingCart', ['$scope', '$http', 'ngProgress', function($scope,$http,ngProgress) {

        $('[data-toggle="popover"]').popover();

        $('.description').ThreeDots({max_rows:4});

        $scope.cart = {};
        $scope.cart.subtotal = '0.00';
        $scope.cart_count = 0;
        $scope.isRemoved = false;
        $scope.isRelatedProduct = true;

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

                if ($indicator == 0) {

                    $.growl({

                        title: ' <strong>Shopping Cart</strong>',
                        message: '<p>Item <code>' + data.sku + '</code> has been removed from shopping cart</p>'

                    }, {

                        type: 'info',
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


            //alert(link);

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
                    placement: {

                        align: 'right'
                    }

                });

            });


        };

        /**
         * function to place order
         */

        $scope.create_account = function(callback) {

         // TODO: Account creation function

            $http({

                method: 'POST',
                url: '/store/create-account',
                data: {

                    'name' : $("#name").val(),
                    'email' : $("#email").val(),
                    'password' : $("#password").val(),
                    'password_confirmation' : $("#password_confirmation").val()

                }
            }).success(function (data, status, headers, config) {



            }).error(function (data, status, headers, config) {

                if (status == '404') {

                    alert('Page Not Found!');

                }

            });

        };

        $scope.placeOrder = function() {




        };

        $http({
            method: 'GET',
            url: '/store/refresh-cart'
        }).success(function (data, status, headers, config) {

            //console.log(data.cart);
            $scope.cart = data.cart;
            $scope.cart_total = data.total;
            $scope.cart_count = data.count;
            //console.log($scope.cart.count);

        }).error(function (data, status, headers, config) {

            if(status == '404') {

                //alert('Page Not Found');

            }
        });


    }]);



}(jQuery));