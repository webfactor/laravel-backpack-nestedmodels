<script type="text/ng-template" id="preview.html">
    <div class="modal-header">
        <h1><% node.title %></h1>
        <h3 ng-if="node.subtitle"><% node.subtitle %></h3>
    </div>
    <div class="modal-body" ng-if="node.content">
        <div class="module-content" ng-bind-html="node.content.body | trustedHtml" ng-if="node.content.body"></div>
        <a href="<% node.content.url %>" target="_blank" ng-if="node.content.url"><% node.content.url %></a>

        <h4 ng-if="node.content.attachments.length">Anhänge</h4>
        <a href="file/<% attachment %>" target="_blank" ng-repeat="attachment in node.content.attachments">
            <% attachment %>
        </a>
    </div>
    <div class="modal-footer">
        <a type="button" class="btn btn-default" href="{{ $crud->route }}/<% node.id %>/edit">
            <i class="fa fa-edit"></i> Bearbeiten
        </a>
        <a type="button" class="btn btn-default" ng-click="close()">
            <i class="fa fa-times"></i> Schließen
        </a>
    </div>
</script>