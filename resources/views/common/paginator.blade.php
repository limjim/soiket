<?php
//validate parameters
if (!isset($accessPageId)) {
    echo "<span class='text-bold text-red'>Render paginator: missing parameter accessPageId to access pageId value</span>";
    return;
}
if (!isset($accessPagesCount)) {
    echo "<span class='text-bold text-red'>Render paginator: missing parameter accessPagesCount to access pagesCount value</span>";
    return;
}

if (!isset($accessFind)) {
    echo "<span class='text-bold text-red'>Render paginator: missing parameter accessFind to access find() function</span>";
    return;
}
?>

<div ng-show="<?= $accessPagesCount ?> > 0" ng-init="steps = [ - 5, - 4, - 3, - 2, - 1, 0, 1, 2, 3, 4, 5 ]"
>
    <ul class="pagination pull-right" style="margin: 0px 15px;">
        <li><a ng-click="<?= $accessPageId ?> = 0;<?= $accessFind ?>">First</a></li>
        <li class="@{{step == 0 ? 'active' : ''}}"
            ng-repeat="step in steps"
            ng-show="$parent.<?= $accessPageId ?> + step >= 0 && $parent.<?= $accessPageId ?> + step < $parent.<?= $accessPagesCount ?>">
            <a ng-click="$parent.<?= $accessPageId ?> = $parent.<?= $accessPageId ?> + step;$parent.<?= $accessFind ?>" style="cursor: pointer;"
            >
                @{{$parent.pageId + step + 1}}
            </a>
        </li>

        <li><a ng-click="<?= $accessPageId ?> = <?= $accessPagesCount ?> -1;<?= $accessFind ?>">End</a></li>
    </ul>
</div>