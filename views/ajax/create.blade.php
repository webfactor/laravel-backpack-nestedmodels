@extends('backpack_ajax.modal_layout')

@section('header')
    <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        @include('crud::inc.grouped_errors')

        <!-- load the view from the application if it exists, otherwise load the one in the package -->
            @if(view()->exists('vendor.backpack.crud.form_content'))
                @include('vendor.backpack.crud.form_content', ['fields' => $crud->getFields('create')])
            @else
                @include('crud::form_content', ['fields' => $crud->getFields('create')])
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('backpack_ajax.inc.form_save_buttons')
@endsection

@push('crud_fields_scripts')
<script>
    $('#create_form').submit(function (e) {
        return false;
    });
</script>

@endpush