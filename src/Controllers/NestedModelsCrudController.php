<?php

namespace Webfactor\Laravel\Backpack\NestedModels\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use Illuminate\Http\Request;

class NestedModelsCrudController extends CrudController
{
    public function setup()
    {
        parent::setup();

        $this->crud->setListView('nestedmodels::treecrud');
        $this->crud->orderBy('lft');

        $this->crud->allowAccess('reorder');
    }

    public function index()
    {
        $this->crud->hasAccessOrFail('list');

        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        $entries = $this->data['crud']->getEntries();
        $this->data['entries'] = $this->crud->model::loadTree($entries);

        return view($this->crud->getListView(), $this->data);
    }

    public function create()
    {
        $request = \Request::instance();

        if ($parent = $request->get('parent')) {
            $this->crud->addField([
                'name'  => 'parent_id',
                'type'  => 'hidden',
                'value' => $parent
            ]);
        }

        if ($request->wantsJson()) {
            return $this->ajaxCreate($request);
        }

        return parent::create();
    }

    public function ajaxCreate(Request $request)
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('nestedmodels::ajax.create', $this->data);
    }

    public function storeCrud(StoreRequest $request = null)
    {
        if ($request->wantsJson()) {
            return $this->ajaxStore($request);
        }

        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function ajaxStore(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // insert item in the db
        return $this->crud->create($request->except(['save_action', '_token', '_method']));
    }

    public function saveReorder()
    {
        $this->crud->hasAccess('reorder');
        $request = \Request::instance();

        $this->crud->model::rebuildTree($request->all());

        return (string) true;
    }
}
