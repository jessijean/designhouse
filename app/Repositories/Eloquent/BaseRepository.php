<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Exceptions\NoModelDefined;
use App\Repositories\Contracts\BaseInterface;

abstract class BaseRepository implements BaseInterface {

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    public function all()
    {
        return $this->model->get();
    }

    protected function getModelClass()
    {
        if( !method_exists($this, 'model'))
        {
            throw new ModelNotDefined();
        }

        return app()->make($this->model());

    }


}
