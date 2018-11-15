<?php
namespace App\Http\Controllers\Tests;

use App\Http\Transformers\TestsTransformer;
use App\Models\testModel;

class WodeController extends testController
{
    public function index()
    {
        $tests = testModel::all();
        return $this->collection($tests, new TestsTransformer());
    }

    public function show($id)
    {
        $test = testModel::find($id);
        if (!$test) {
            return $this->response->errorNotFound('Test not found');
        }
        return $this->item($test, new TestsTransformer());
    }
}
