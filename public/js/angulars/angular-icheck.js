(function () {

    'use strict';

    angular.module('icheck', []).directive('icheck', function ($timeout, $parse) {
        return {
            restrict: 'AC',
            require: 'ngModel',
            link: function($scope, element, $attrs, ngModel) {
                return $timeout(function() {
                    var value = $attrs['value'];
                    var icheckConfig = {
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%'
                    };
                    if (typeof ($attrs.icheck) != 'undefined' && typeof ($scope[$attrs.icheck]) != 'undefined') {
                        icheckConfig = $scope[$attrs.icheck];
                    }

                    $scope.$watch($attrs['ngModel'], function(newValue){
                        $(element).iCheck('update');
                    });

                    return $(element).iCheck(icheckConfig).on('ifChanged', function(event) {
                        if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
                            $scope.$apply(function() {
                                return ngModel.$setViewValue(event.target.checked);
                            });
                        }
                        if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {
                            return $scope.$apply(function() {
                                return ngModel.$setViewValue(value);
                            });
                        }
                    });
                });
            }
        };
    });

})();