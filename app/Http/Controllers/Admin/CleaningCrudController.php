<?php

namespace App\Http\Controllers\Admin;

use App\CleaningService;
use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Services\FileUploader;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CleaningRequest as StoreRequest;
use App\Http\Requests\CleaningRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CleaningCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CleaningCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\CleaningService');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cleaning');
        $this->crud->setEntityNameStrings('клінінг', 'клінінг');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in CleaningRequest
//        $this->crud->setRequiredFields(StoreRequest::class, 'create');
//        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->addColumn([ // image
            'label' => "Тип робіт",
            'name' => "type",
        ]);

//        $this->crud->addColumn([ // image
//            'label' => "Фото",
//            'name' => "photo",
//            'type' => 'image',
//        ]);
//        $this->crud->addColumn([
//            // run a function on the CRUD model and show its return value
//            'name' => "user_phone",
//            'label' => "Номер користувача", // Table column heading
//            'type' => "model_function",
//            'function_name' => 'getUserPhone', // the method in your Model
//            // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
//            // 'limit' => 100, // Limit the number of characters shown
//        ]);
        $this->crud->addColumn([
            // run a function on the CRUD model and show its return value
            'name' => "user_organization",
            'label' => "Організація", // Table column heading
            'type' => "model_function",
            'function_name' => 'getUserOrganization', // the method in your Model
            // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
            // 'limit' => 100, // Limit the number of characters shown
        ]);
        $this->crud->addColumn([ // image
            'name' => "status",
            'label' => "Статус",
            'type' => "model_function",
            'function_name' => 'getStatusString'
        ]);

        $this->crud->allowAccess('show');
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->addButtonFromModelFunction('line', 'Коментарі', 'openComments', 'beginning');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function show($id)
    {
        $this->crud->addColumn([ // image
            'label' => "Фото",
            'name' => "photo",
            'type' => 'image',
        ]);
        $this->crud->addColumn([ // image
            'label' => "Площа поверхні",
            'name' => "area",
        ]);
        $this->crud->addColumn([ // image
            'label' => "Тип поверхні",
            'name' => "surface_type",
        ]);
        $this->crud->addColumn([ // image
            'label' => "Терміновість",
            'name' => "urgency",
        ]);
        $this->crud->addColumn([
            // run a function on the CRUD model and show its return value
            'name' => "user_phone",
            'label' => "Номер користувача", // Table column heading
            'type' => "model_function",
            'function_name' => 'getUserPhone', // the method in your Model
            // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
            // 'limit' => 100, // Limit the number of characters shown
        ]);
        $this->crud->setColumnDetails('type', [ // image
            'label' => "Тип робіт",
            'name' => "type",
            'limit' => 1000,
        ]);
        return parent::show($id);
    }

    public function showComments($id)
    {
        $comments = Comment::where('type', 'cleaning')
            ->where('commentable_id', $id)
            ->orderBy('created_at', 'desc')->get();

        return view(
        'comments',
            [
                'comments' => $comments,
                'crud' => $this->crud,
            ]
        );
    }

    public function saveComment(CommentRequest $request, $id)
    {

        $comment = new Comment();
        $comment->text = $request->text;
        $comment->commentable_id = $id;
        $comment->type = 'cleaning';
        $comment->user_id = auth()->guard('admin')->id();
        if($request->hasFile('photo')) {
            /** @var FileUploader $uploader */
            $uploader = app(FileUploader::class);
            $filePath = $uploader->upload($request->file('photo'));
            $comment->photo = $filePath;
        }
        $comment->save();
        $model = CleaningService::find($id);
        $model->calculateStatus();
        return redirect()->route('cleaning.comments', ['id'=>$id]);
    }
}
