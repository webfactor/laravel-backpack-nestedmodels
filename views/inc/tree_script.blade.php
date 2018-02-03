<script>
    window.modulesList = window.modulesList || angular.module('ModulesList', ['ui.tree', 'ui.bootstrap'], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    window.modulesList.filter('trustedHtml', function ($sce) {
        return $sce.trustAsHtml;
    });

    window.modulesList.controller('ModulesController', function ($scope, $http, $uibModal) {

        $scope.treeOptions = {
            beforeDrop: beforeDrop,
            dropped: dropped
        };

        $scope.collapseAll = function () {
            $scope.$broadcast('angular-ui-tree:collapse-all');
        };

        $scope.expandAll = function () {
            $scope.$broadcast('angular-ui-tree:expand-all');
        };

        $scope.canDropInto = function (node) {
            return node.type === 'category' || node.type === 'root' || node.type === null
        };

        $scope.toggleTree = function (event, scope) {
            event.stopPropagation();

            scope.toggle();
        };

        $scope.toggleDropdown = function(event, scope) {
            event.stopPropagation();

            var dropdownToggle = angular.element(event.currentTarget);
            if (dropdownToggle.hasClass('open')) {
                dropdownToggle.removeClass('open')
            } else {
                dropdownToggle.addClass('open')
            }
        };

        $scope.editModule = function (event, scope) {
            event.stopPropagation();

            var node = scope.$modelValue;
            var url = '{{ url($crud->route) }}/' + node.id + '/edit';
            window.location.href = url;
        };

        $scope.publishModule = function (event, scope) {
            event.stopPropagation();

            var node = scope.$modelValue;
            var url = '{{ url($crud->route) }}/' + node.id + '/publish';

            $http({
                url: url,
                method: 'POST',
                data: {
                    publish: !node.published
                }
            }).then(function (response) {
                node.published = !node.published;
                new PNotify({
                    title: node.published ? 'Freigegeben' : 'Gesperrrt',
                    text: 'Das Modul wurde erfolgreich ' + node.published ? 'freigegeben.' : 'gesperrt.',
                    type: "success"
                });
            }, function (error) {
                new PNotify({
                    title: "Fehler",
                    text: "Es ist ein Fehler aufgetreten. Bitte versuche es später noch einmal.",
                    type: "error"
                });
            });
        };

        $scope.deleteModule = function (event, scope) {
            event.stopPropagation();

            var node = scope.$modelValue;
            var url = '{{ url($crud->route) }}/' + node.id;

            if (confirm('Möchtest Du dieses Modul und alle untergeordneten Module wirklich entfernen?') == true) {
                $http({
                    url: url,
                    method: 'DELETE'
                }).then(function (response) {
                    new PNotify({
                        title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
                        text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
                        type: "success"
                    });
                    scope.remove();
                }, function (error) {
                    new PNotify({
                        title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
                        text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
                        type: "warning"
                    });
                });
            }
        };

        $scope.newChild = function (event, scope, type) {
            event.stopPropagation();

            var current = scope.$modelValue;
            $uibModal.open({
                templateUrl: 'modal.html',
                controller: 'ModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                windowClass: 'new-child-modal',
                resolve: {
                    nodeScope: function () {
                        return scope;
                    },
                    type: function () {
                        return type;
                    }
                }
            });
        };

        $scope.preview = function (event, scope) {
            event.stopPropagation();
            var current = scope.$modelValue;

            $uibModal.open({
                templateUrl: 'preview.html',
                controller: 'PreviewController',
                controllerAs: '$ctrl',
                size: 'sm',
                windowClass: 'preview-modal',
                resolve: {
                    nodeScope: function () {
                        return scope;
                    }
                }
            });
        };


        function beforeDrop(e) {
            if (!$scope.permissions.reorder) return false;

            var source = e.source.nodeScope.$modelValue;
            var dest = e.dest.nodesScope.node;

            return confirm('Soll das wikrlich verschoben werden?');
        }

        function dropped(e) {
            $http.post('{{ url($crud->route) }}/reorder', $scope.list)
                .then(function (response) {
                    new PNotify({
                        title: "{{ trans('backpack::crud.reorder_success_title') }}",
                        text: "{{ trans('backpack::crud.reorder_success_message') }}",
                        type: "success"
                    });
                }, function (error) {
                    new PNotify({
                        title: "{{ trans('backpack::crud.reorder_error_title') }}",
                        text: "{{ trans('backpack::crud.reorder_error_message') }}",
                        type: "error"
                    });
                    // in case of reorder error this will reset the view
                    var indexTo = e.dest.index;
                    var indexFrom = e.source.index;
                    var movedNode = e.dest.nodesScope.node.children.splice(indexTo, 1)[0];
                    e.source.nodesScope.node.children.splice(indexFrom, 0, movedNode);
                });
        }
    });

    window.modulesList.controller('PreviewController', function ($scope, $uibModalInstance, nodeScope) {
        $scope.node = nodeScope.node;
        $scope.close = function () {
            $uibModalInstance.dismiss('cancel');
        }
    });

    window.modulesList.controller('ModalController', function ($scope, $uibModalInstance, $http, nodeScope, type) {

        var parent = nodeScope.node.id;

        console.log(nodeScope.node);

        $http.get('{{url( $crud->route )}}/create?type=' + type + '&parent=' + parent).then(function (response) {
            $scope.data = response.data;
        });

        $scope.nodeScope = nodeScope;

        $scope.save = function () {
            if (typeof tinyMCE !== 'undefined' && tinyMCE) {
                tinyMCE.triggerSave();
            }

            var summernote = $('.summernote');
            if (summernote.length !== 0) {
                summernote.html(summernote.code());
            }

            var form = $('#create_form');
            var formData = new FormData(form[0]);

            $.ajax({
                url: '{{ url($crud->route)}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    Accept: 'application/json',
                },
                success: function (data) {
                    $scope.nodeScope.node.children.push(data);
                    $uibModalInstance.close();
                    new PNotify({
                        title: "{{ trans('backpack::crud.insert_success') }}",
                        type: "success"
                    });
                },
                error: function (error) {
                    console.log(error);
                    var message = $.map(error.responseJSON, function (value, index) {
                        return value.join('\n');
                    }).join('\n');

                    new PNotify({
                        title: "{{ trans('backpack::crud.please_fix') }}",
                        text: message,
                        type: "error"
                    });
                }
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

    });

    window.modulesList.directive('compile', ['$compile', function ($compile) {
        return function (scope, element, attrs) {
            scope.$watch(
                function (scope) {
                    return scope.$eval(attrs.compile);
                },
                function (value) {
                    element.html(value);
                    $compile(element.contents())(scope);
                }
            )
        };
    }]);

    angular.element(document).ready(function () {
        angular.forEach(angular.element('[ng-app]'), function (ctrl) {
            var ctrlDom = angular.element(ctrl);
            if (!ctrlDom.hasClass('ng-scope')) {
                angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
            }
        });
    });

</script>