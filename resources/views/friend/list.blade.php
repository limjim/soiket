@include('friend.filter')
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center vertical-center" style="width: 20px;">#</th>
                <th class="text-center vertical-center">Ảnh đại diện</th>
                <th class="text-center vertical-center">Tên</th>
                <th class="text-center vertical-center"></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="item in items track by $index">
                <td>@{{$index + 1}}</td>
                <td class="text-center vertical-center" style="width: 10%">
                    <img ng-if="item.avatar" class="img-responsive" ng-src="@{{ item.avatar }}" />
                </td>
                <td class="vertical-center">@{{item.full_name}}</td>
                <td class="text-center vertical-center">
        
                </td>
            </tr>
            <tr ng-if="products.length == 0">
                <td colspan="9">Không tìm thấy dữ liệu</td>
            </tr>
        </tbody>
    </table>
</div>