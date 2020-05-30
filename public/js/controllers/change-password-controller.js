vhhSeller.controller('ChangePasswordController', function ($scope, $http, $timeout, $rootScope) {

    this.prototype = new BaseController($scope, $http, $timeout, $rootScope);

    $scope.seller = {};

    $scope.save = function () {
        if(typeof($scope.seller.password) == 'undefined' || $scope.seller.password == '' || $scope.seller.password == null) {
            $scope.showNotification('Lỗi!', 'Mời nhập mật khẩu cũ. Vui lòng kiểm tra lại...', 'error', 'glyphicon-remove');
            return;
        }

        if(typeof($scope.seller.newPassword) == 'undefined' || $scope.seller.newPassword == '' || $scope.seller.newPassword == null) {
            $scope.showNotification('Lỗi!', 'Mời nhập mật khẩu mới. Vui lòng kiểm tra lại...', 'error', 'glyphicon-remove');
            return;
        }
        if ($scope.seller.newPassword != $scope.seller.confirmNewPassword) {
            $scope.showNotification('Lỗi!', 'Mật khẩu mới không khớp. Vui lòng kiểm tra lại...', 'error', 'glyphicon-remove');
            return;
        }
        $scope.showLoading();
        $http.post(API_URL + '/seller/password', {
            'password': $scope.seller.password,
            'new-password': $scope.seller.newPassword,
            'confirm-new-password': $scope.seller.confirmNewPassword
        }).then(function mySuccess(response) {
            $scope.hideLoading();
            if (response.data.status == STATUS_SUCCESSFUL) {
                $scope.reset();
                $scope.showNotification('Thành công', response.data.message, 'success', 'glyphicon-ok');
            } else {
                $scope.showNotification('Lỗi!', response.data.message, 'error', 'glyphicon-remove');
            }
        }, function myError() {
            $scope.hideLoading();
            $scope.showNotification('Lỗi!', 'Có lỗi xảy ra trong quá trình đổi mật khẩu...', 'error', 'glyphicon-remove');
        });
    }

    $scope.reset = function () {
        $scope.seller = {};
    }


});