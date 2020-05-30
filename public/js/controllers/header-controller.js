app.controller('HeaderController', function ($scope, $http, $timeout, $rootScope) {

    $scope.notifications = []; $scope.countUnseem = 0;

    this.prototype = new BaseController($scope, $http, $timeout, $rootScope);

    $scope.addNew = function () {
        $rootScope.$broadcast("actionNew");
    }

    $scope.seenAll = function () {
        var notificationId = [];
        angular.forEach($scope.notifications, function (item) {
            if (item.is_send == 0) {
                item.is_send = 1;
                notificationId.push(item.id);
            }
        });

        if (notificationId.length > 0) {
            $scope.updateSeen();
            $http.patch(API_URL + '/seller/notification/'  + notificationId.join('-'), {isSend: 1});
        }
    }

    $scope.seenNotification = function (item) {
        if (typeof (item.is_send) != 'undefined' && item.is_send == 0) {
            item.is_send = 1;
            $scope.updateSeen();
            $http.patch(API_URL + '/seller/notification/' + item.id, { isSend: 1 }).then(function mySucess(response) {
                window.location.href = '/order?notificationOrder=' + item.url;
            });
        } else {
            window.location.href = '/order?notificationOrder=' + item.url
        }
    }

    $scope.updateSeen = function () {
        $scope.countUnseem = 0;
        angular.forEach($scope.notifications, function (item) {
            if (item.is_send == 0) $scope.countUnseem++;
        });

    }

    $scope.getNotification = function () {
        // $http.get(API_URL + '/seller/notification').then(function mySuccess(response) {
        //     if (response.data.status == STATUS_SUCCESSFUL) {
        //         $scope.notifications = response.data.data;
        //         $scope.updateSeen();
        //     }
        // });
    }

    angular.element(document).ready(function () {
        setInterval(function () {
            $scope.getNotification();
        }, 30 * 1000);
    });

    $scope.getNotification();
});