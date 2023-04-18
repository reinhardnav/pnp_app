<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientsCrudController extends CrudController
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
		CRUD::setModel(\App\Models\Clients::class);
		CRUD::setRoute(config('backpack.base.route_prefix') . '/clients');
		CRUD::setEntityNameStrings('clients', 'clients');
	}

	/**
	 * Define what happens when the List operation is loaded.
	 *
	 * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
	 * @return void
	 */
	protected function setupListOperation()
	{

		CRUD::column('company_name')
			->label('Company Name');

		CRUD::column('first_name')
			->label('First Name');

		CRUD::column('last_name')
			->label('Last Name');

		CRUD::column('phone')
			->label('Phone');

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
		CRUD::setValidation(ClientsRequest::class);

		CRUD::field('company_name')
			->label('Company Name')
			->wrapper(['class' => 'form-group col-md-12']);

		CRUD::field('first_name')
			->label('First Name')
			->wrapper(['class' => 'form-group col-md-6']);

		CRUD::field('last_name')
			->label('Last Name')
			->wrapper(['class' => 'form-group col-md-6']);

		CRUD::field('email')
			->label('Email Address')
			->type('email')
			->attributes(['placeholder' => 'Enter email, user@domain.com'])
			->wrapper(['class' => 'form-group col-md-6']);;

		CRUD::field('phone')
			->label('Phone')
			->wrapper(['class' => 'form-group col-md-6']);

		CRUD::field('status')
			->type('select2_from_array')
			->options([
				"1" => "Active",
				"0" => "Inactive",
			])
			->wrapper(['class' => 'form-group col-md-6']);;

		CRUD::field('nimble_crm_id')
			->label('Nimble CRM ID')
			->wrapper(['class' => 'form-group col-md-6']);

		$this->crud->addField([  // Select
			'label' => "Assigned Staff",
			'type' => 'select',
			'name' => 'created_by', // the db column for the foreign key
			'entity' => 'user',
			'attribute' => 'first_name',
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

		/**
		 * Fields can be defined using the fluent syntax or array syntax:
		 * - CRUD::field('price')->type('number');
		 * - CRUD::addField(['name' => 'price', 'type' => 'number']));
		 */
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
