app.controller('OrderController', function ($scope, $http, $timeout, $rootScope) {

    this.prototype = new BaseController($scope, $http, $timeout, $rootScope);

    var self = this;

    $scope.orders = [];
    $scope.totalOrders = 0;
    $scope.objConfirm = null;
    $scope.objViewDetail = null;
    $scope.keySearch = '';
    $scope.pageSize = 20;
    $scope.pageIndex = 1;
    $scope.rangeDate = '';
    $scope.steps = [];
    $scope.garenality = null;
    $scope.selectOrders = [];
    $scope.companyInfo = '';

    var status_order_page = '';

    this.initialize = function () {

        $scope.getParagrams();
        $scope.getGarenality();
        $scope.findOrders();
        var currentUrl = new URL(window.location.href);
        if (currentUrl.searchParams.get('notificationOrder')) {
            $scope.keySearch = currentUrl.searchParams.get('notificationOrder');
        }
    };

    $scope.getParagrams = function () {
        $scope.keySearch = _GET('s') ? _GET('s') : '';
        $scope.pageSize = _GET('page_size') ? _GET('page_size') : 20;
        $scope.pageIndex = _GET('page') ? _GET('page') : 1;
        status_order_page = _GET('status') ? _GET('status') : '';
    }

    this.buildSteps = function () {
        $scope.steps = [];
        var countSteps = parseInt(($scope.totalOrders - 1) / $scope.pageSize) + 1;
        $scope.pageIndex = $scope.pageIndex <= countSteps ? $scope.pageIndex : countSteps;
        var start = 1;
        var end = 1;

        if (countSteps <= 1) {
            end = 0;
            return;
        } else if (countSteps <= 5) {
            end = countSteps;
        } else if ($scope.pageIndex < 3) {
            start = 1;
            end = start + 4;
        }   else if ($scope.pageIndex + 3 > countSteps) {
            end = countSteps;
            start = end - 4;
        }   else {
            start = $scope.pageIndex - 2;
            end = $scope.pageIndex + 2;
        }
        $scope.steps.count = countSteps;
        for (var i = start; i <= end; i++) {
            $scope.steps.push(i);
        }
    }

    $scope.findOrders = function () {
        var url = API_URL + '/seller/' + SELLER_ID + '/get-order?source=seller';
        url = url + '&page_size=' + $scope.pageSize;
        url = url + '&page_index=' + $scope.pageIndex;
        url = $scope.keySearch == '' ? url : url + '&key_search=' + $scope.keySearch;
        url = status_order_page == '' ? url : url + '&status=' + status_order_page;
        url = $scope.rangeDate == '' ? url : url + '&range_date=' + $scope.rangeDate;
        var exportUrl = url.replace('seller', 'api');
        exportUrl = exportUrl.replace("get-order", "export-excel-order");
        exportUrl = exportUrl + '&auth_key=' + AUTH_KEY;
        $scope.exportOrderUrl = exportUrl;
        $http.get(url, {}).then(function (response) {
            if (response.data.status == 'successful') {
                $scope.totalOrders = response.data.count_all;
                self.buildSteps();
                response.data.result.forEach(function(elementOrder) {
                    elementOrder.draft_data = JSON.parse(elementOrder.draft_data);
                    elementOrder = self.formatStatus(elementOrder);
                    elementOrder.order_items.forEach(function(elementOrderItem) {
                        if (elementOrderItem.image_url != null && elementOrderItem.image_url != '' && elementOrderItem.image_url.indexOf('http') < 0)
                        {
                            elementOrderItem.image_url_cdn = IMAGE_URL + '/' + elementOrderItem.image_url;
                        } else {
                            elementOrderItem.image_url_cdn = elementOrderItem.image_url;
                        }
                    });
                    elementOrder.select = false;
                });
                $scope.orders = response.data.result;
                $http.get(API_URL + '/api/setting?key=company.info').then(function (retVal) {
                    if (retVal.data.status == 'successful') {
                        $scope.companyInfo = retVal.data.data;
                    };
                });
            }
        });
    }

    $scope.customerName = function(itemOrder) {
        if ( itemOrder && itemOrder.draft_data && itemOrder.draft_data != null) {
            return itemOrder.draft_data.full_name
        } else if ( itemOrder && itemOrder.order_customer && itemOrder.order_customer != null ) {
            return itemOrder.order_customer.full_name
        } else {
            return "";
        }
    }

    $scope.getGarenality = function () {
        var url = API_URL + '/seller/' + SELLER_ID + '/order/gerenal';
        $http.get(url, {}).then(function (response) {
            if (response.data.status == 'successful') {
                $scope.garenality = response.data.result;
            }

        });
    }

    $scope.getObjectViewDetail = function($event) {
        var clickedObject = angular.element($event.currentTarget);
        var index = clickedObject.attr('data-index');
        $scope.objViewDetail = $scope.orders[index];
        $scope.objViewDetail.index = index;
    }

    $scope.getObjectConfirm = function($event) {
        var clickedObject = angular.element($event.currentTarget);
        var index = clickedObject.attr('data-index');
        var newStatus =  clickedObject.attr('data-status');
        $scope.objConfirm = {
            id: $scope.orders[index].id,
            sync_id: $scope.orders[index].sync_id,
            code: $scope.orders[index].code,
            index: index,
            newStatus: newStatus,
            modalTitle: newStatus == 'cancelled_wo_out_products' ? 'Hủy đơn hàng' : 'Xác nhận còn hàng cho đơn',
        }
    }

    $scope.changeStatusOrder = function () {
        console.log($scope.objConfirm);
        var data_sync = {
            sync_id: $scope.objConfirm.sync_id,
            is_verified: $scope.objConfirm.newStatus == 'out_products_in_progress' ? true : false
        };
        $http.post(WAREHOUSE_DOMAIN + '/service/inoutput/confirm', data_sync).then(function (res) {
            if (res.data.status != 'successful') {
                $scope.showNotification('Lỗi!', 'Thao tác không thành công, vui lòng thử lại.', 'error', 'glyphicon-ban-circle');
            } else {
                var data_post = {
                    order_id: $scope.objConfirm.id,
                    status: $scope.objConfirm.newStatus
                };
                $http.post(API_URL + '/seller/' + SELLER_ID + '/change-status-order', data_post).then(function (response) {
                    if (response.data.status == 'successful') {
                        var this_order = $scope.orders[$scope.objConfirm.index];
                        this_order.status = data_post.status;
                        this_order = self.formatStatus(this_order);
                        $scope.showNotification('Thành công!', 'Thao tác bạn thực hiện đã thành công.', 'success', 'glyphicon-ok');
                    } else {
                        $scope.showNotification('Lỗi!', 'Thao tác không thành công, vui lòng thử lại.', 'error', 'glyphicon-ban-circle');
                    }
                });
            }
        }, function (data) {
            $scope.showNotification('Lỗi!', 'Thao tác không thành công, vui lòng thử lại.', 'error', 'glyphicon-ban-circle');
        });




    }

    $scope.keyPressSearch = function ($keyEvent) {
        if ($keyEvent.which === 13) {
            $scope.search();
        }
    }

    $scope.pickRangeDate = function () {
        $scope.findOrders();
    }

    $scope.search = function () {
        $scope.findOrders();
    }

    $scope.refesh = function () {
        $scope.rangeDate = '';
        $scope.keySearch = '';
        self.initialize();
    }

    $scope.goToPage = function (pageIndex) {
        $scope.pageIndex = pageIndex;
        $scope.findOrders();
    }

    $scope.formatPhoneNumber = function (phoneNumber) {
        if (phoneNumber) {
            phoneNumber = phoneNumber.replace(/(\d{4})(\d{3})(\d{3})/gi, '$1.$2.$3');
        }
        return phoneNumber;
    }

    $scope.getSlug = function (name) {
        return $scope.toFriendlyString(name);
    }

    $scope.getTimeStamp = function (dateTime) {
        if ( dateTime ) {
            dateTime  = dateTime.replace(/\-/g, '/');
        }
        return new Date(dateTime).getTime();
    }

    this.formatStatus = function (elementOrder) {
        switch (elementOrder.status) {
            case 'pending':
                elementOrder.status_color = 'danger';
                elementOrder.status_vi = 'Chờ x.nhận';
                break;
            case 'cancelled_wo_out_products':
                elementOrder.status_color = 'default';
                elementOrder.status_vi = 'Huỷ đ.hàng';
                break;
            case 'request_out':
                elementOrder.status_color = 'warning';
                elementOrder.status_vi = 'Đã xác nhận';
                break;
            case 'out_products_in_progress':
                elementOrder.status_color = 'warning';
                elementOrder.status_vi = 'Đang xuất hàng';
                break;
            case 'out_products':
                elementOrder.status_color = 'warning';
                elementOrder.status_vi = 'Đã xuất hàng';
                break;
            case 'delivering':
                elementOrder.status_color = 'warning';
                elementOrder.status_vi = 'Đang vận chuyển';
                break;
            case 'delivered':
                elementOrder.status_color = 'primary';
                elementOrder.status_vi = 'Đã giao hàng';
                break;
            case 'finished':
                elementOrder.status_color = 'success';
                elementOrder.status_vi = 'Thành công';
                break;
            case 'request_re_in':
                elementOrder.status_color = 'default';
                elementOrder.status_vi = 'Y. cầu trả lại';
                break;
            case 're_in':
                elementOrder.status_color = 'default';
                elementOrder.status_vi = 'Trả lại';
                break;
            default:
                elementOrder.status_color = 'default';
                elementOrder.status_vi = 'Không xác định';
        }
        return elementOrder;
    }

    function _GET(q,s) {
        s = (s) ? s : window.location.search;
        var re = new RegExp('(^&)' + q + '=([^&]*)', 'i');
        return (s = s.replace(/^\?/, '&').match(re)) ? s = s[2] : s = '';
    }

    //print inoutput
    $scope.printOrder = function () {
        var countSelectOrders = $scope.countSelectOrders();
        if (countSelectOrders <= 0) {
            $scope.showNotification('Lỗi!', 'Vui lòng chọn đơn hàng.', 'error', 'glyphicon-ban-circle');
            return;
        }
        $scope.selectOrders = [];
        $scope.orders.forEach((order) => {
            if ( order.select && (order.status == 'out_products_in_progress' || order.status == 'out_products' )) {
                $scope.selectOrders.push(order);
            }
        });
        if ( $scope.selectOrders.length <= 0 ) {
            $scope.showNotification('Lỗi!', 'Không thể in phiếu. Vui lòng chọn các đơn ở trạng thái Đang Xuất Hàng hoặc Đã Xuất Hàng!', 'error', 'glyphicon-ban-circle');
            return;
        }

        $http.post('/order/print-order', {
            orders: $scope.selectOrders,
            companyInfo: JSON.parse($scope.companyInfo),
        }).then(function (response) {
            if (response.data.status == 'successful') {
                window.setTimeout(function () {
                    var wd = window.open();
                    wd.document.write(response.data.html);
                    wd.document.close();
                }, 1000);
            } else {
                $scope.showNotification('Lỗi!', 'Thao tác không thành công, vui lòng thử lại.', 'error', 'glyphicon-ban-circle');   
            }
        }, function (error) {
            $scope.showNotification('Lỗi!', 'Thao tác không thành công, vui lòng thử lại.', 'error', 'glyphicon-ban-circle');
            throw new Error(error);
        });
    }
    $scope.countSelectOrders = () => {
        var retVal = 0;
        $scope.orders.forEach((order) => {
            if ( order.select ) {
                retVal++;
            }
        });
        return retVal;
    }

    this.initialize();

});
