<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiCrudController;
use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends ApiCrudController
{
    private $fields = [
        'parent_id',
        'name',
        'slug',
        'description',
        'status',
        'meta',
        'no_order',
        'created_at',
        'updated_at'
    ];

    private $includes = ['parent'];

    /**
     * @Override
     * @return string
     */
    protected function getModel()
    {
        return Category::class;
    }

    /**
     * @Override
     * @param $model
     * @param null $id
     * @return array
     */
    protected function getValidateRules($model, $id = null)
    {
        return [
            'name' => 'required',
            'slug' => 'required',
        ];
    }

    /**
     * @Override
     * @param $model
     * @param $request
     * @return mixed
     */
    protected function findAll($model, $request)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedSorts($this->fields)
            ->allowedFields($this->fields)
            ->allowedFilters($this->fields)
            ->allowedIncludes($this->includes)
            ->paginate($request->get('size', 10))
            ->appends($request->query());
    }

    /**
     * @Override
     * @param $model
     * @param $id
     * @return mixed
     */
    protected function findOne($model, $id)
    {
        return QueryBuilder::for($model)
            ->allowedFields($this->fields)
            ->allowedIncludes($this->includes)
            ->find($id);
    }
}
