<?php namespace AbbyJanke\BackpackMeta\app\Http\Controllers\Admin;


use AbbyJanke\BackpackMeta\app\Http\Requests\MetaRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use AbbyJanke\BackpackMeta\app\Http\Requests\MetaRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class MetaCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Backpack\Meta\app\Http\Models\Meta');

        $this->crud->allowAccess('show');

        $this->crud->setRoute(config('backpack.base.route_prefix').'/meta');
        $this->crud->setEntityNameStrings('meta setting', 'Meta Settings');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumn([
          'name' => 'id'
        ]);

        $this->crud->addColumn([
          'name' => 'key'
        ]);

        $this->crud->addColumn([
          'name' => 'display',
          'label' => 'Display Name'
        ]);

        $this->crud->addColumn([
          'name' => 'model'
        ]);

        $this->crud->addField([ // select_from_array
            'name' => 'model',
            'label' => "Metable Model",
            'type' => 'select_from_array',
            'options' => $this->getMetableModels(),
            'hint' => 'Which model to attach this Meta option to.',
            'allows_null' => false,
        ]);

        $this->crud->addField([
            'name' => 'key',
            'label' => 'Unique Key',
            'type' => 'text',
            'hint' => 'Unique key for this Meta option for easy access of data.',
        ]);

        $this->crud->addField([
            'name' => 'display',
            'label' => 'Display Name (optional)',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'helper',
            'label' => 'Helper Text (optional)',
            'type' => 'text',
            'hint' => 'Displayed only in admin interface below the field.',
        ]);

        $this->crud->addField([
            'name' => 'type',
            'label' => 'Field Type',
            'type' => 'select_from_array',
            'options' => $this->getFieldTypes(),
            'hint' => 'Which model to attach this Meta option to.',
            'allows_null' => false,
        ]);

    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    /**
     * Get the list of models that the user wishes to be metable.
     * @return array
     **/
    private function getMetableModels()
    {
      $models = config('backpack.meta.models');
      sort($models);

      $displayModels = [];
      foreach($models as $model) {
        $displayModels[$model] = $model;
      }

      return $displayModels;
    }

    /**
     * Get all available field types from view folder.
     * @return array
     **/
    private function getFieldTypes()
    {
      if(file_exists(resource_path('views/vendor/backpack/crud/fields'))) {
        $views = scandir(resource_path('views/vendor/backpack/crud/fields'));
      } else {
        $views = scandir(base_path('vendor/backpack/crud/src/resources/views/fields'));
      }

      $displayTypes = [];

      unset($views[0]);
      unset($views[1]);

      foreach($views as $view) {
        $displayTypes[] = strstr($view, '.', true);
      }

      return $displayTypes;
    }

}
