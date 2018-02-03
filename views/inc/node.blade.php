<!-- Node template -->
<script type="text/ng-template" id="nodes_renderer.html">
    <div class="tree-node tree-node-content"
         ng-click="preview($event, this)"
    >
        <a class="btn btn-default btn-xs" ng-if="node.children && node.children.length > 0" data-nodrag
           ng-click="toggleTree($event, this)">
            <i class="fa" ng-class="{'fa-folder': collapsed, 'fa-folder-open': !collapsed}"></i>
        </a>
        <i class="fa" ng-class="{
                    'fa-file-text': node.type == 'text',
                    'fa-external-link': node.type == 'link',
                }"></i>
        &nbsp;
        <% node.title %>
        <a class="btn btn-info btn-xs pull-right" ui-tree-handle>
            <i class="fa fa-bars"></i>
        </a>
        <a ng-if="permissions.delete" class="pull-right btn btn-danger btn-xs" data-nodrag
           ng-click="deleteModule($event, this)" style="margin-right: 8px;">
            <i class="fa fa-trash"></i>
        </a>
        <a ng-if="permissions.update" class="pull-right btn btn-primary btn-xs" data-nodrag
           ng-click="editModule($event, this)" style="margin-right: 8px;"><i class="fa fa-edit"></i></a>
        <a ng-if="permissions.publish && !node.published" class="pull-right btn btn-default btn-xs" data-nodrag
           ng-click="publishModule($event, this)" style="margin-right: 8px;">Freigeben</a>
        <a ng-if="permissions.publish && node.published" class="pull-right btn btn-default btn-xs" data-nodrag
           ng-click="publishModule($event, this)" style="margin-right: 8px;">Sperren</a>
        <div id="dropdownMenu<% node.id %>" class="dropdown pull-right"
             ng-click="toggleDropdown($event, this)"
             ng-if="canDropInto(node) && permissions.create"
             data-nodrag>
            <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="margin-right: 8px;" aria-expanded="false">
                Kategorie/Modul hinzufügen
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu<% node.id %>">
                <li><a ng-click="newChild($event, this, 'category')">Unterkategorie</a></li>
                <li><a ng-click="newChild($event, this, 'text')">Text-Modul</a></li>
                <li><a ng-click="newChild($event, this, 'link')">Link-Modul</a></li>
            </ul>
        </div>
    </div>
    </div>
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
</script>