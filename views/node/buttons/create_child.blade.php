<button class="btn btn-default btn-xs pull-right"
        style="margin-right: 8px;"
        ng-click="newChild($event, this)"
        >
    <i class="fa fa-plus"></i>
</button>


{{--
    ----------------------------------------
    | You can have some kind of dropdown here.
    | We will add a 'type' attribute to the create route.
    | Just call "newChild($event, this, '<your_type>' on ng-click.
    | This way you could create completely different models by redirecting in your NestedModelCrudController subclass.
    ----------------------------------------
    SAMPLE CODE
    ----------------------------------------

<div id="dropdownMenu<% node.id %>" class="dropdown pull-right"
     ng-click="toggleDropdown($event, this)"
     ng-if="canDropInto(node) && permissions.create"
     data-nodrag>
    <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="margin-right: 8px;"
            aria-expanded="false">
        Kategorie/Modul hinzufügen
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu<% node.id %>">
        <li><a ng-click="newChild($event, this, 'category')">Unterkategorie</a></li>
        <li><a ng-click="newChild($event, this, 'text')">Text-Modul</a></li>
        <li><a ng-click="newChild($event, this, 'link')">Link-Modul</a></li>
    </ul>
</div>

--}}
