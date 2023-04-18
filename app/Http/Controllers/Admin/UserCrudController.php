<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //if(!backpack_user()->hasRole('Admin'))
       //     Abort(403,"Access Denied");

        CRUD::column('first_name')
            ->label('First Name');

        CRUD::column('last_name')
            ->label('Last Name');

        $this->crud->addColumns([

            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.permission'), // foreign key model
            ],
        ]);

        if (backpack_pro()) {
            // Role Filter
            $this->crud->addFilter(
                [
                    'name'  => 'role',
                    'type'  => 'dropdown',
                    'label' => trans('backpack::permissionmanager.role'),
                ],
                config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                        $query->where('role_id', '=', $value);
                    });
                }
            );

            // Extra Permission Filter
            $this->crud->addFilter(
                [
                    'name'  => 'permissions',
                    'type'  => 'select2',
                    'label' => trans('backpack::permissionmanager.extra_permissions'),
                ],
                config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                        $query->where('permission_id', '=', $value);
                    });
                }
            );
        }


        CRUD::column('email')
	        ->label('Email Address');

	    CRUD::removeButton('show');



    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {


        CRUD::field('first_name','text')
	        ->label('First Names')
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('last_name')
	        ->label('Last Name')
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('phone')
	        ->label('Best Contact Number')
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('email')
	        ->label('Email Address')
            ->type('email')
            ->attributes(['placeholder' => 'Enter email, user@domain.com'])
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('office365_login')
	        ->label('O365 Username')
	        ->tab('Office 365')
	        ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('office365_password')
	        ->label('O365 Pass')
	        ->tab('Office 365')
	        ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('office365_password')
            ->label('O365 Pass')
            ->tab('Office 365')
            ->wrapper(['class' => 'form-group col-md-6']);


        $this->crud->addField([
            // two interconnected entities
            'label'             => trans('backpack::permissionmanager.user_role_permission'),
            'field_unique_name' => 'user_role_permission',
            'type'              => 'checklist_dependency',
            'name'              => ['roles', 'permissions'],// the methods that defines the relationship in your Model

            'wrapper' =>['class' => 'form-group col-md-12'],
            'subfields'         => [
                'primary' => [
                    'label'            => trans('backpack::permissionmanager.roles'),
                    'name'             => 'roles', // the method that defines the relationship in your Model
                    'entity'           => 'roles', // the method that defines the relationship in your Model
                    'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                    'attribute'        => 'name', // foreign key attribute that is shown to user
                    'model'            => config('laravel-permission.models.role'), // foreign key model
                    'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                    //'number_columns'   => 3, //can be 1,2,3,4,6
                ],
                'secondary' => [
                    'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                    'name'           => 'permissions', // the method that defines the relationship in your Model
                    'entity'         => 'permissions', // the method that defines the relationship in your Model
                    'entity_primary' => 'roles', // the method that defines the relationship in your Model
                    'attribute'      => 'name', // foreign key attribute that is shown to user
                    'model'          => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
                    'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                ],
            ],
        ]);

	    CRUD::addSaveAction([
		    'name' => 'save_action_one',
		    'button_text' => 'Save',
		    'visible' => function ($crud) {
			    return true;
		    },
		    'referrer_url' => function ($crud, $request, $itemId) {
			    return $crud->route;
		    },
		    'order' => 1,
	    ]);



	    CRUD::removeSaveActions(['save_and_back', 'save_and_edit', 'save_and_new', 'save_and_preview']);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
