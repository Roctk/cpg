<?php
/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 23.03.2019
 * Time: 21:26
 */
namespace App\Http\Controllers\Admin;

use App\Course;
use App\Services\Notifications\DeviceNotificationsSender;
use Backpack\CRUD\app\Http\Controllers\CrudController;

//use App\Http\Requests\CourseCreateCrudRequest as StoreRequest;
use App\Http\Requests\CourseCrudRequest as StoreRequest;
use App\Http\Requests\CourseCrudRequest as UpdateRequest;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

class CourseCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel("App\Course");
        $this->crud->setRoute("admin/course");
        $this->crud->setEntityNameStrings('курс', 'курсы');

        $this->crud->addColumn([
            'name' => 'name',
            'label' => "Название",
        ]);
        $this->crud->addColumn([
            'name' => 'price',
            'label' => "Цена",
        ]);
        $this->crud->addColumn([
            'name' => 'date_time',
            'label' => 'Дата',
        ]);
        $this->crud->addColumn([
            'name' => 'date_time_end',
            'label' => 'Дата окончания',
        ]);
        $this->crud->addColumn([ // image
            'label' => "Фото",
            'name' => "photo",
            'type' => 'image',
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => "Название"
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => "Описание",
            'type' => 'textarea'
        ]);
        $this->crud->addField([
            'name' => 'price',
            'label' => "Цена",
            'type' => 'number',
            'attributes' => ["step" => "any"], // allow decimals
        ]);
        $this->crud->addField([
            'name' => 'date_time',
            'label' => 'Дата начала',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'ru'
            ]
        ]);
        $this->crud->addField([
            'name' => 'date_time_end',
            'label' => 'Дата окончания',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'ru'
            ]
        ]);
        $this->crud->addField([ // image
            'label' => "Фото",
            'name' => "photo",
            'type' => 'image',
            'upload' => true,
            'crop' => false, // set to true to allow cropping, false to disable
            'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
            // 'prefix' => 'uploads/images/profile_pictures/' // in case you only store the filename in the database, this text will be prepended to the database value
        ]);
        $this->crud->addField([ // image
            'label' => "Отправить уведомление",
            'name' => 'send_notification',
            'fake' => true,
            'type' => 'checkbox'
        ]);
        $this->crud->addClause('where', 'is_adv', '=', $this->isAdv());
    }

    public function store(StoreRequest $request)
    {
        if($request->get('send_notification', false)) {
            /** @var DeviceNotificationsSender $notificationsSender */
            $notificationsSender = app(DeviceNotificationsSender::class);
            $notificationsSender->sendNotification(['body' => $request->get('name')]);
        }

        $file = $request->files->get('photo');
        if($file) {
            $path = Course::uploadPhoto($file);
            $request->merge(['photo' => $path]);
            $request->resetFiles();
        }

        return parent::storeCrud($request);
    }

    public function update($id,UpdateRequest $request)
    {
        if($request->hasFile('photo')) {
            $request->merge([
                'photo' => Course::uploadPhoto($request->photo),
                'id' => $id,
                'save_action' => $request->get('action', 'save_and_back')
            ]);
            $request->resetFiles();
        }
        else if($request->get("remove", '0') == '1') {
            $request->merge([
                'photo' => null,
            ]);
        }
        return parent::updateCrud($request);
    }

    protected function isAdv(): int
    {
        return 0;
    }

}