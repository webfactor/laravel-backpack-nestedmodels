<!-- Node template -->
<script type="text/ng-template" id="nodes_renderer.html">
    <div class="tree-node tree-node-content"
         ng-click="preview($event, this)"
    >
        @include('nestedmodels::node.button_collapse')
        @include('nestedmodels::node.content')
        @include('nestedmodels::node.buttons')
    </div>
    @include('nestedmodels::node.childrendering')
</script>