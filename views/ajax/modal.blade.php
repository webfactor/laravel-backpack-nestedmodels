@stack('crud_fields_styles')
{!! Form::open(['id' => 'create_form', 'url' => $crud->route, 'method' => 'post', 'files'=>$crud->hasUploadFields('create')]) !!}
<div class="modal-header">
    @yield('header')

</div>
<div class="modal-body" id="modal-body">
    @yield('content')
</div>

<div class="modal-footer">
    @yield('footer')
</div>
{!! Form::close() !!}
@stack('crud_fields_scripts')