app.controller('ProfileController', function ($scope, $http, $timeout, $rootScope) {

    this.prototype = new BaseController($scope, $http, $timeout, $rootScope);

    $scope.seller = {}; $scope.types = [{ key: 'personal', value: 'Cá nhân' }, { key: 'company', value: 'Công ty' }];

    $scope.save = function () {
        if (!$scope.buildDataSeller()) return;
        if (!$scope.agree) {
            $scope.showNotification('Thông báo!', 'Bạn chưa chấp nhận điều khoản của chúng tôi.', 'error', 'glyphicon-remove');
            return;
        }
        $scope.showLoading();
        $http.post(API_URL + '/seller/profile', $scope.seller).then(function mySuccess(response) {
            $scope.hideLoading();
            if (response.data.status == STATUS_SUCCESSFUL) {
                $scope.showNotification('Thành công', response.data.message, 'success', 'glyphicon-ok');
            } else {
                $scope.showNotification('Lỗi!', response.data.message, 'error', 'glyphicon-remove');
            }
        }, function myError() {
            $scope.hideLoading();
            $scope.showNotification('Lỗi!', 'Có lỗi xảy ra trong quá trình lấy thông tin gian hàng...', 'error', 'glyphicon-remove');
        });
    }

    $scope.buildDataSeller = function () {
        if(typeof($scope.seller.name) == 'undefined' || $scope.seller.name == '' || $scope.seller.name == null) {
            $scope.showNotification('Lỗi!', 'Mời nhập tên gian hàng', 'error', 'glyphicon-remove');
            return false;
        }
        if(typeof($scope.seller.name_organization) == 'undefined' || $scope.seller.name_organization == '' || $scope.seller.name_organization == null) {
            $scope.showNotification('Lỗi!', 'Mời nhập Tên cá nhân/tổ chức', 'error', 'glyphicon-remove');
            return false;
        }
        if(typeof($scope.seller.phone) == 'undefined' || $scope.seller.phone == '' || $scope.seller.phone == null) {
            $scope.showNotification('Lỗi!', 'Mời nhập Số điện thoại', 'error', 'glyphicon-remove');
            return false;
        } else if (!$scope.isValidPhone($scope.seller.phone)) {
            $scope.showNotification('Lỗi!', 'Số điện thoại không đúng định dạng', 'error', 'glyphicon-remove');
            return false;
        }
        if(typeof($scope.seller.address) == 'undefined' || $scope.seller.address == '' || $scope.seller.address == null) {
            $scope.showNotification('Lỗi!', 'Mời nhập Địa chỉ gian hàng', 'error', 'glyphicon-remove');
            return false;
        }
        if($scope.seller.email != '' && !$scope.isValidEmail($scope.seller.email)) {
            $scope.showNotification('Lỗi!', 'Địa chỉ email không đúng định dạng', 'error', 'glyphicon-remove');
            return false;
        }
        if(typeof($scope.seller.website) != 'undefined' && $scope.seller.website != '' && $scope.seller.website != null) {
            if (!$scope.isValidLink($scope.seller.website)) {
                $scope.showNotification('Lỗi!', 'Website không đúng định dạng', 'error', 'glyphicon-remove');
                return false;
            }
        }
        if(typeof($scope.seller.facebook) != 'undefined' && $scope.seller.facebook != '' && $scope.seller.facebook != null) {
            if (!$scope.isValidLink($scope.seller.facebook)) {
                $scope.showNotification('Lỗi!', 'Địa chỉ Facebook không đúng định dạng', 'error', 'glyphicon-remove');
                return false;
            }
        }
        if(typeof($scope.seller.youtube) != 'undefined' && $scope.seller.youtube != '' && $scope.seller.youtube != null) {
            if (!$scope.isValidLink($scope.seller.youtube)) {
                $scope.showNotification('Lỗi!', 'Địa chỉ Youtube không đúng định dạng', 'error', 'glyphicon-remove');
                return false;
            }
        }
        return true;
    }

    $scope.find = function () {
        $scope.showLoading();
        $http.get(API_URL + '/seller/profile').then(function mySuccess(response) {
            $scope.hideLoading();
            if (response.data.status == STATUS_SUCCESSFUL) {
                $scope.seller = response.data.seller;
            } else {
                $scope.showNotification('Lỗi!', response.data.message, 'error', 'glyphicon-remove');
            }
        }, function myError() {
            $scope.hideLoading();
            $scope.showNotification('Lỗi!', 'Có lỗi xảy ra trong quá trình lấy thông tin gian hàng...', 'error', 'glyphicon-remove');
        });
    }

    $scope.reset = function () {
        $scope.seller.name = '';
        $scope.seller.phone = '';
        $scope.seller.address = '';
        $scope.seller.name_organization = '';
        $scope.seller.website = '';
        $scope.seller.sell_code = '';
        $scope.seller.description = '';
        $scope.seller.facebook = '';
        $scope.seller.skype = '';
        $scope.seller.youtube = '';
    }

    $scope.find();

});