const STATUS_SUCCESSFUL = 'successful';
const STATUS_FAIL = 'fail';

var app = angular.module('soiket', ['ngSanitize', 'ngAnimate', 'ngFileUpload', 'localytics.directives']);
app.config(['chosenProvider', function (chosenProvider) {
    chosenProvider.setOption({
        no_results_text: 'Không tìm thấy kết quả!',
        placeholder_text_multiple: 'Chọn một từ khóa',
        placeholder_text: 'Chọn một từ khóa'
    });
}]);

var VIETNAMESE_N_ASCII_MAP = {
    "à": "a", "ả": "a", "ã": "a", "á": "a", "ạ": "a", "ă": "a", "ằ": "a", "ẳ": "a", "ẵ": "a",
    "ắ": "a", "ặ": "a", "â": "a", "ầ": "a", "ẩ": "a", "ẫ": "a", "ấ": "a", "ậ": "a", "đ": "d",
    "è": "e", "ẻ": "e", "ẽ": "e", "é": "e", "ẹ": "e", "ê": "e", "ề": "e", "ể": "e", "ễ": "e",
    "ế": "e", "ệ": "e", "ì": 'i', "ỉ": 'i', "ĩ": 'i', "í": 'i', "ị": 'i', "ò": 'o', "ỏ": 'o',
    "õ": "o", "ó": "o", "ọ": "o", "ô": "o", "ồ": "o", "ổ": "o", "ỗ": "o", "ố": "o", "ộ": "o",
    "ơ": "o", "ờ": "o", "ở": "o", "ỡ": "o", "ớ": "o", "ợ": "o", "ù": "u", "ủ": "u", "ũ": "u",
    "ú": "u", "ụ": "u", "ư": "u", "ừ": "u", "ử": "u", "ữ": "u", "ứ": "u", "ự": "u", "ỳ": "y",
    "ỷ": "y", "ỹ": "y", "ý": "y", "ỵ": "y", "À": "A", "Ả": "A", "Ã": "A", "Á": "A", "Ạ": "A",
    "Ă": "A", "Ằ": "A", "Ẳ": "A", "Ẵ": "A", "Ắ": "A", "Ặ": "A", "Â": "A", "Ầ": "A", "Ẩ": "A",
    "Ẫ": "A", "Ấ": "A", "Ậ": "A", "Đ": "D", "È": "E", "Ẻ": "E", "Ẽ": "E", "É": "E", "Ẹ": "E",
    "Ê": "E", "Ề": "E", "Ể": "E", "Ễ": "E", "Ế": "E", "Ệ": "E", "Ì": "I", "Ỉ": "I", "Ĩ": "I",
    "Í": "I", "Ị": "I", "Ò": "O", "Ỏ": "O", "Õ": "O", "Ó": "O", "Ọ": "O", "Ô": "O", "Ồ": "O",
    "Ổ": "O", "Ỗ": "O", "Ố": "O", "Ộ": "O", "Ơ": "O", "Ờ": "O", "Ở": "O", "Ỡ": "O", "Ớ": "O",
    "Ợ": "O", "Ù": "U", "Ủ": "U", "Ũ": "U", "Ú": "U", "Ụ": "U", "Ư": "U", "Ừ": "U", "Ử": "U",
    "Ữ": "U", "Ứ": "U", "Ự": "U", "Ỳ": "Y", "Ỷ": "Y", "Ỹ": "Y", "Ý": "Y", "Ỵ": "Y"
};

function BaseController($scope, $http, $rootScope) {

    $scope.showLoading = function () {
        Pace.stop();
        Pace.start();
    }

    $scope.hideLoading = function () {
        Pace.stop();
    }

    $scope.showNotification = function (title, text, type, icon) {
        new PNotify({
            title: title,
            text: text,
            type: type,
            icon: 'glyphicon ' + icon,
            addclass: 'snotify',
            closer: true,
            delay: 2000
        });
    }

    $scope.isJsonString = function (str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    $scope.htmlDecodeEntities = function (input){
        var e = document.createElement('div');
        e.innerHTML = input;
        return e.childNodes[0].nodeValue;
    }

    $scope.isValidLink = function (link) {
        var regex = /(^|\s)((https?:\/\/)[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi;
        return regex.test(link);
    }

    $scope.isValidEmail = function (email) {
        var regex = /^[\w\.-]+@[\w\.-]+\.\w{2,5}$/;
        var retVal = email != null && email.match(regex) != null;
        return retVal;
    }

    $scope.isValidPhone = function(phone) {
        if (phone == null) {
            return false;
        }
        //ELSE:
        var stdPhone = $scope.standardizePhone(phone);
        var regex = /^0(9\d{8}|1\d{9}|[2345678]\d{7,14})$/;
        return stdPhone.match(regex) != null;
    }

    $scope.standardizePhone = function (phone) {
        if (phone == null) {
            return phone;
        }
        if (!isNaN(phone)) {
            phone = phone.toString();
        }
        //ELSE:
        return phone.replace(/[^0-9]/g, "");
    }

    $scope.getByCode = function (list, code) {
        var retVal = null;
        list.forEach(function (item) {
            if (item.code == code) {
                retVal = item;
            }
        });
        return retVal;
    };

    $scope.getByField = function (list, fieldName, value) {
        var retVal = null;
        list.forEach(function (item) {
            if (item[fieldName] == value) {
                retVal = item;
            }
        });
        return retVal;
    };

    $scope.moneyToString = function (price) {
        if (price == null || price.toString().match(/^\-?[0-9]+(\.[0-9]+)?$/) == null) {
            return "NA";
        }
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $scope.toFriendlyString = function (originalString) {
        var retval = "";
        if (originalString == null || originalString.length == 0) {
            return originalString;
        }
        //ELSE:
        var removedDuplicatedSpacesString = originalString.replace(/\s+/g, " ");
        var removedVietnameseCharsString = "";
        for (var idx = 0; idx < removedDuplicatedSpacesString.length; idx++) {
            var ch = removedDuplicatedSpacesString[idx];
            var alternativeChar = VIETNAMESE_N_ASCII_MAP[ch];
            if (alternativeChar != null) {
                removedVietnameseCharsString += alternativeChar;
            } else {
                removedVietnameseCharsString += ch;
            }
        }
        retval = removedVietnameseCharsString.toLowerCase()
                .replace(/[^0-9a-zA-Z]/g, "-")
                .replace(/\-+/g, "-");
        retval = retval.charAt(retval.length - 1) === "-" ? retval.substring(0, retval.length - 1) : retval;
        return retval;
    };
}