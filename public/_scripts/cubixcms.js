/**
 *  CubixCMS Javascript
 *  ------------------------------------
 *  Author:  Sean Pollock
 *  Date:    02/17/2015
 *
 */
(function() {


    var app = angular.module('cubixcms', ['ngProgress'],function($interpolateProvider) {

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

    app.directive('backButton', ['$window', function($window) {

       return {

           restrict: 'A',

           link: function(scope, element, attrs) {

               element.bind('click', function () {

                    $window.history.back();

               });
           }
       };

    }]);

    app.controller('shoppingCart', ['$scope', '$http', 'ngProgress', function($scope,$http,ngProgress) {

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

                $.growl({

                    title: ' <strong>Shopping Cart</strong>',
                    message: '<p>Shopping cart has been updated</p>'

                }, {

                    type: 'info',
                    placement: {

                        align: 'center'
                    }

                });

            }).error(function (data, status, headers, config) {

                $.growl({

                    title: ' <strong>Error</strong>',
                    message: '<p>Failed updating shopping cart.</p>'

                }, {

                    type: 'danger',
                    placement: {

                        align: 'center'

                    }

                });

            });

        };

        $scope.remove = function($rowid,index) {

            //alert('Index: ' + index);

            //$scope.cart.splice(index, 1);
            //console.log($scope.cart);
            $http({

                method: 'POST',
                url: '/store/remove-cart',
                data: {

                    'rowid' : $rowid
                }

            }).success(function (data, status, headers, config) {



                //$scope.cart = data.cart;

                $scope.cart = data.cart;

                //console.log($scope.cart);

                //console.log($scope.cart);

                // TODO: remove row from table

                //$scope.cart.splice(index, 1);
                $scope.cart.subtotal = data.subtotal;
                $scope.cart_total = data.subtotal;
                $scope.isRelatedProduct = false;
                $scope.cart_count = data.count;
                //alert('done');
                $.growl({

                    title: ' <strong>Shopping Cart</strong>',
                    message: '<p>Item <code>' + data.sku + '</code> has been removed from shopping cart</p>'

                }, {

                    type: 'info',
                    placement: {

                        align: 'center'
                    }

                });

                //console.log($scope.cart.count);


            }).error(function (data, status, headers, config) {

                $.growl({

                    title: ' <strong>Error</strong>',
                    message: '<p>Failed deleting item from shopping cart.</p>'

                }, {

                    type: 'danger',
                    placement: {

                        align: 'center'

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

                        align: 'center'

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

                        align: 'center'
                    }

                });

            });


        };

        /**
         * function to place order
         */

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

$(document).ready(function() {

    /*
    var maxHeight = -1;

    $('.store-panel').each(function () {


        maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();

    });

    $('.store-panel').each(function () {

        $(this).height(maxHeight+50);

    });

    $('.store-panel').matchHeight({property: 'min-height'});
    $('.store-panel').find('.thumbnail').matchHeight(true);
*/
    //$("#myQty").placard();
    $('[data-toggle="popover"]').popover();
    $('.description').ThreeDots({max_rows:4});
});