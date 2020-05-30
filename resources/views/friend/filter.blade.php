<form class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-md-1">Từ khóa</label>
        <div class="col-md-3">
            <input class="form-control" type="text" ng-model="filter.full_name" style="width: 100%;"/>
        </div>
        <label class="control-label col-md-1">Giới tính</label>
        <div class="col-md-2">
            <select class="form-control" ng-model="filter.gender" ng-options="item.code as item.value for item in genders" ng-change="find(true)">
                <option value="">Không xác định</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-info" ng-click="find()"><i class="fa fa-search"></i> Lọc</button>
            <button type="button" class="btn btn-danger" ng-click="clear()"><i class="fa fa-times"></i> Clear</button>
        </div>
    </div>
</form>