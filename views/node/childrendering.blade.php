<ol ng-if="!canDropInto(node) || !permissions.reorder" ui-tree-nodes="" data-nodrop-enabled="true"
    ng-model="node.children"
    ng-class="{hidden: collapsed}">
    <li ng-repeat="node in node.children" ui-tree-node data-expand-on-hover="true"
        ng-include="'nodes_renderer.html'">
    </li>
</ol>
<ol ng-if="canDropInto(node) && permissions.reorder" ui-tree-nodes="" ng-model="node.children"
    ng-class="{hidden: collapsed}">
    <li ng-repeat="node in node.children" ui-tree-node data-expand-on-hover="true"
        ng-include="'nodes_renderer.html'">
    </li>
</ol>