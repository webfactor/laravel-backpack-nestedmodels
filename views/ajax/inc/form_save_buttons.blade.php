<div id="saveActions" class="form-group">

    <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">

    <button type="submit" class="btn btn-success" ng-click="save()">
        <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
        <span data-value="{{ $saveAction['active']['value'] }}">{{ $saveAction['active']['label'] }}</span>
    </button>

    <button class="btn btn-default" type="button" ng-click="cancel()">
        <span class="fa fa-ban"></span>{{ trans('backpack::crud.cancel') }}
    </button>
</div>