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
                    message: '<p>Item <code>' + data.sku + '</code> has been saved to shopping cart</p>'

                }, {

                    type: 'info'

                });

                //console.log($scope.cart.count);


            }).error(function (data, status, headers, config) {

                $.growl({

                    title: '<strong>Error</strong>',
                    message: '<p>Failed adding item to shopping cart.</p>'

                }, {

                    type: 'error'

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
            $scope.cart.subtotal = data.subtotal;
            $scope.cart.count = data.count;
            console.log($scope.cart.count);

        }).error(function (data, status, headers, config) {

            if(status == '404') {

                //alert('Page Not Found');

            }
        });


    }]);



}(jQuery));

$(document).ready(function() {

    var maxHeight = -1;

    $('.store-panel').each(function () {


        maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();

    });

    $('.store-panel').each(function () {

        $(this).height(maxHeight+50);

    });

    $('.store-panel').matchHeight({property: 'min-height'});
    $('.store-panel').find('.thumbnail').matchHeight(true);


});