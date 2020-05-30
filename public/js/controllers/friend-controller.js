
app.controller('FriendController', function ($scope, $http, $timeout, $rootScope, Upload) {
   
    this.prototype = new BaseController($scope, $http, $timeout, $rootScope);
    $scope.items = [];
    $scope.pageId = 0; 
    $scope.pageSize = 40; 
    $scope.pagesCount = 0;
    $scope.genders = [
        {code: 0, value: 'Nữ'},
        {code: 1, value: 'Nam'}
    ];
    $scope.filter = {};

    function initialize() {
        $scope.find(true);
    }

    $scope.clear = function () {
        $scope.filter = {};
        $scope.find();
    }

    $scope.find = function(reset) {
        if (reset == true) {
            $scope.pageId = 0;
            $scope.filter.pageId = 0;
        }
        $http({
            method: 'GET',
            url: '/service/friend/find' + $scope.buildFilterData()
        }).then(function success(response) {
            if (response.data.status == 'successful') {
                $scope.items = response.data.result;
                $scope.pageId = parseInt(response.data.pageId);
                $scope.pagesCount = parseInt(response.data.pagesCount);
            }
        });
    }

    $scope.buildFilterData = function () {
        var retVal = angular.copy($scope.filter);
        if(typeof(retVal) != 'undefined' && retVal != '' && retVal != null) {
            return '?' + $.param(retVal);
        } else {
            return '';
        }
    }

    $scope.fetchFriend = function() {
        
    }

    initialize();
});
