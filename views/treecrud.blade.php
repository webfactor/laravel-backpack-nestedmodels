@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
            <small>{{ trans('backpack::crud.all') }}
                <span>{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}
                .
            </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a>
            </li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">{{ trans('backpack::crud.list') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row" ng-app="ModulesList" ng-controller="ModulesController">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box box-default">
                <div class="box-header {{ $crud->hasAccess('create')?'with-border':'' }}">
                    <div class="box-title"></div>
                    <a href="{{ url($crud->route.'/create') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                        <span class="ladda-label"><i class="fa fa-plus"></i> Neue Überschrift</span>
                    </a>
                    {{--@include('crud::inc.button_stack', ['stack' => 'top'])--}}
                    <button class="pull-right btn btn-sm btn-default" ng-click="collapseAll()">
                        <i class="fa fa-bars"></i> Alles einklappen
                    </button>
                    <button class="pull-right btn btn-sm btn-default" ng-click="expandAll()">
                        <i class="fa fa-signal fa-rotate-270"></i> Alles aufklappen
                    </button>
                </div>
                <div class="box-body" ng-init="list = {{ json_encode($entries) }};
                                               permissions = {
                                                    create: {{ $crud->hasAccess('create') ? 'true' : 'false' }},
                                                    update: {{ $crud->hasAccess('update') ? 'true' : 'false' }},
                                                    delete: {{ $crud->hasAccess('delete') ? 'true' : 'false' }},
                                                    reorder: {{ $crud->hasAccess('reorder') ? 'true' : 'false' }},
                                                    publish: {{ $crud->hasAccess('publish') ? 'true' : 'false' }}
                        }
">

                    <div ui-tree="treeOptions" id="tree-root" data-nodrop-enabled="!permissions.reorder" ng-if="list.length > 0">
                        <ol ui-tree-nodes data-expand-on-hover="true" ng-model="list">
                            <li ng-repeat="node in list" ui-tree-node ng-include="'nodes_renderer.html'"></li>
                        </ol>
                    </div>
                    <div class="alert alert-info" ng-if="list.length == 0">
                        Es wurden noch keine Module angelegt.
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

        @include('nestedmodels::node')

        @include('nestedmodels::modal')

        @include('nestedmodels::preview')
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/webfactor/angular-ui-tree/dist/angular-ui-tree.min.css') }}">
    @include('nestedmodels::inc.tree_style')
    @include('nestedmodels::inc.modal_style')
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/webfactor/angular-ui-tree/dist/angular-ui-tree.js') }}"></script>

    <!-- TREE SCRIPT -->
    @include('nestedmodels::inc.tree_script')
@endsection
