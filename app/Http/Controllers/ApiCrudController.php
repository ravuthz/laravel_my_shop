<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class ApiCrudController extends ApiBaseController
{

    protected $model;
    protected $title;

    protected abstract function getModel();

    protected function getTitle($template = '')
    {
        if (!$this->title) {
            $this->title = (new \ReflectionClass($this->model()))->getShortName();
        }
        return Str::of($template)->replace(':name', $this->title)->lower()->ucfirst();
    }

    protected function getValidateRules($model, $id = null)
    {
        return [];
    }

    protected function getValidateMessages($model, $id = null)
    {
        return [];
    }

    protected function model()
    {
        if (!$this->model) {
            $this->model = app($this->getModel());
        }
        return $this->model;
    }

    protected function listItem($model, $request)
    {
        $size = $request->get('size', 1);
        return $model->paginate($size);
    }

    protected function showItem($model, $id)
    {
        return $model->find($id);
    }

    protected function saveItem($model, $request, $id = null)
    {
        $rules = $this->getValidateRules($model, $id);
        $messages = $this->getValidateMessages($model, $id);
        $inputs = !empty($rules) ? $request->validate($rules, $messages) : $request->all();
        $model->fill($inputs)->save();
        return $model;
    }

    // Can be override
    protected function deleteItem($model)
    {
        $model->delete();
        return null;
    }

    /**
     *
     * Controller Actions below
     *
     */
    public function index(Request $request)
    {
        $data = $this->listItem($this->model(), $request);
        return $this->sendJson($data, $this->getTitle('The :name fetched successfully.'));
    }

    public function show($id)
    {
        $data = $this->showItem($this->model(), $id);
        if (!$data) {
            return abort($this->sendError(null, $this->getTitle('The :name was not found'), 404));
        }
        return $this->sendJson($data, $this->getTitle('The :name fetched successfully.'));
    }

    public function store(Request $request)
    {
        $data = $this->saveItem($this->model(), $request);
        return $this->sendJson($data, $this->getTitle('The :name created successfully.'), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $this->saveItem($this->model(), $request, $id);
        return $this->sendJson($data, $this->getTitle('The :name updated successfully.'));
    }

    public function destroy($id)
    {
        $data = $this->showItem($this->model(), $id);
        if (!$data) {
            return abort($this->sendError(null, $this->getTitle('The :name was not found'), 404));
        }
        return $this->sendJson($this->deleteItem($data), $this->getTitle('The :name deleted successfully.'));
    }

}
