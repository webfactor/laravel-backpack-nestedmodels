<!-- Tree template -->
<script type="text/ng-template" id="tree.html">
    <div ui-tree="treeOptions" id="tree-root" data-nodrop-enabled="!permissions.reorder" ng-if="list.length > 0">
        <ol ui-tree-nodes data-expand-on-hover="true" ng-model="list">
            <li ng-repeat="node in list" ui-tree-node ng-include="'nodes_renderer.html'"></li>
        </ol>
    </div>
    <div class="alert alert-info" ng-if="list.length == 0">
        {{ trans('backpack::crud.emptyTable') }}
    </div>
</script>
