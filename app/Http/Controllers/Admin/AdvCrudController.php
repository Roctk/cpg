<?php
/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 23.03.2019
 * Time: 21:26
 */
namespace App\Http\Controllers\Admin;

use App\Course;
use Backpack\CRUD\app\Http\Controllers\CrudController;

//use App\Http\Requests\CourseCreateCrudRequest as StoreRequest;
use App\Http\Requests\CourseCrudRequest as StoreRequest;
use App\Http\Requests\CourseCrudRequest as UpdateRequest;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

class AdvCrudController extends CourseCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setModel("App\Course");
        $this->crud->setRoute("admin/adv");
        $this->crud->setEntityNameStrings('курс', 'Реклама');

        $this->crud->addClause('where', 'is_adv', '=', $this->isAdv());
    }

    public function store(StoreRequest $request)
    {
        $request->merge(['is_adv' => $this->isAdv()]);
        return parent::store($request);
    }

    protected function isAdv(): int
    {
        return 1;
    }

}