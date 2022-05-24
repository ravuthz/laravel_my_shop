<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiCrudController;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends ApiCrudController
{
    protected function getModel()
    {
        return Category::class;
    }

    protected function getTitle($template = '')
    {
        return Str::of($template)->replace(':name', '*category*')->lower()->ucfirst();
    }

    protected function getValidateRules($model, $id = null)
    {
        return [
            'name' => 'required',
            'slug' => 'required'
        ];
    }
}
