<a class="btn btn-default btn-xs" ng-if="node.children && node.children.length > 0" data-nodrag
   ng-click="toggleTree($event, this)">
    <i class="fa" ng-class="{'fa-folder': collapsed, 'fa-folder-open': !collapsed}"></i>
</a>