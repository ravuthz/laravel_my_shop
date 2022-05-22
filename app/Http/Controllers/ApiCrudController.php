<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ApiCrudController extends ApiBaseController {

    protected $model;

    protected abstract function getModel();

    protected function getValidateRules($model, $id = null) {
        return [];
    }

    protected function getValidateMessages($model, $id = null) {
        return [];
    }

    protected function model() {
        if (!$this->model) {
            $this->model = app($this->getModel());
        }
        return $this->model;
    }

    protected function listItem($model, $request) {
        return $model->paginate();
    }

    protected function showItem($model, $id) {
        return $model->find($id);
    }

    protected function saveItem($model, $request, $id = null) {
        $rules = $this->getValidateRules($model, $id);
        $messages = $this->getValidateMessages($model, $id);
        $inputs = !empty($rules) ? $request->validate($rules, $messages) : $request->all();
        return $model->fill($inputs)->save();
    }

    // Can be override
    protected function deleteItem($model) {
        $model->destroy();
        return null;
    }

    /**
     *
     * Controller Actions below
     *
     */
    public function index(Request $request) {
        $data = $this->listItem($this->model(), $request);
        return $this->sendJson($data, 'Retrieved successfully.');
    }

    public function show($id) {
        $data = $this->showItem($this->model(), $id);
        if (!$data) {
            return abort($this->sendError(null, 'This resource was not found', 404));
        }
        return $this->sendJson($data, 'Retrieved successfully.');
    }

    public function store(Request $request) {
        $data = $this->saveItem($this->model(), $request);
        return $this->sendJson($data, 'Create successfully.');
    }

    public function update(Request $request, $id) {
        $data = $this->saveItem($this->model(), $request, $id);
        return $this->sendJson($data, 'Updated successfully.');
    }

    public function destroy($id) {
        $data = $this->showItem($this->model(), $id);
        if (!$data) {
            return abort($this->sendError(null, 'This resource was not found', 404));
        }
        return $this->sendJson($this->deleteItem($data), 'Deleted successfully.');
    }

}
