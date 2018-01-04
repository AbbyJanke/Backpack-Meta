<?php

namespace AbbyJanke\BackpackMeta\PanelTraits;

use Backpack\Meta\app\Http\Models\Meta as Model;

trait Meta
{

  /**
   * Get all META fields for the model.
   * @return void
   **/
  public function getMetaFields()
  {
    $model = get_class($this->crud->getModel());
    $fields = Model::where('model', $model)->get();

    foreach($fields as $field) {
      $this->crud->addField([
        'name' => $field->key,
      ]);
    }

  }

}
