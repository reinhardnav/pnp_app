<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClaimantEntryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClaimantEntryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClaimantEntryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ClaimantEntry::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/claimant-entry');
        CRUD::setEntityNameStrings('claimant entry', 'claimant entries');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('first_name');
        CRUD::column('last_name');
        CRUD::column('rank');
        CRUD::column('unit_assignment');
        CRUD::column('claim_type');
        CRUD::column('period_cover');
        CRUD::column('amount');
        CRUD::column('atm_acc_no');
        #CRUD::column('entry_by');
        $this->crud->addColumn( [
            // any type of relationship
            'name'         => 'entry_by', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Entry by', // Table column heading
            // OPTIONAL
            'entity'    => 'user', // the method that defines the relationship in your Model
            // 'attribute' => 'name', // foreign key attribute that is shown to user
            // 'model'     => App\Models\Category::class, // foreign key model
        ]);


        $this->crud->addColumn( [
            'name'  => 'claim_status',
            'label' => 'Status',
            'type'  => 'boolean',
            'options' => [0 => 'Submitted', 1 => 'Approved']
        ]);


        $this->crud->addColumn( [
            'name'  => 'claim_status',
            'label' => 'Status',
            'type'  => 'boolean',
            'options' => [0 => 'Submitted', 1 => 'Approved']
        ]);


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClaimantEntryRequest::class);

        //CRUD::field('first_name');


        CRUD::field('first_name')
            ->label('First Name')
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('last_name')
            ->label('Last Name')
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('rank')
            ->label('Rank')
            ->wrapper(['class' => 'form-group col-md-4']);



        CRUD::field('unit_assignment')
            ->label('Unit Assignment')
            ->wrapper(['class' => 'form-group col-md-4']);;
        $this->crud->addField([
            // CustomHTML
            'name'  => 'separator',
            'type'  => 'custom_html',
            'value' => '<hr>'

        ]);
        CRUD::field('claim_type')
            ->label('Claim Type')
            ->type('select2_from_array')
            ->options([
                "" => "-Select-",
                "1" => "Option One",
                "0" => "Option Two",
            ])->wrapper(['class' => 'form-group col-md-4']);



        $this->crud->addField([   // date_range
            'name'  => ['period_cover', 'period_cover'], // db columns for start_date & end_date
            'label' => 'Event Date Range',
            'type'  => 'date_range',

            // OPTIONALS
            // default values for start_date & end_date
            //'default'            => ['2019-03-28 01:01', '2019-04-05 02:00'],
            // options sent to daterangepicker.js
            'date_range_options' => [
                'drops' => 'down', // can be one of [down/up/auto]
                'timePicker' => true,
                'locale' => ['format' => 'MM/DD/YYYY ']
            ],
            'wrapper'=>['class' => 'form-group col-md-8']
        ]);

        CRUD::field('amount')
            ->label('Amount')
            ->type("number")
            ->wrapper(['class' => 'form-group col-md-4']);

        CRUD::field('atm_acc_no')
        ->label('ATM Account Number')

        ->wrapper(['class' => 'form-group col-md-8']);


        $this->crud->addField([
            // CustomHTML
            'name'  => 'separator2',
            'type'  => 'custom_html',
            'value' => '<hr>'

        ]);


        $this->crud->addField([  // Select
            'label' => "Entry By",
            'type' => 'select',
            'name' => 'entry_by', // the db column for the foreign key
            'entity' => 'user',
            'wrapper'=>['readonly' => 'readonly']
        ]);

        $this->crud->addField([  // Select
            'label' => "Entry By:",
            'type' => 'select',
            'name' => 'entry_by', // the db column for the foreign key
            'entity' => 'user',
            'attributes' => [

                'readonly'  => 'readonly',
            ],
            'wrapper'=>['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([  // Select
            'label' => "Claim Status",
            'type' => 'select_from_array',
            'name' => 'claim_status', // the db column for the foreign key
            'entity' => 'user',
            'attributes' => [

                'readonly'  => 'readonly',
                ],
            'options'     => ['0' => 'Submitted', '1' => 'Approved'],
            'wrapper'=>['class' => 'form-group col-md-4']
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
