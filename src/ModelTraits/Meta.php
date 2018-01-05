<?php

namespace AbbyJanke\BackpackMeta\ModelTraits;

use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Request;
use AbbyJanke\BackpackMeta\app\Http\Models\Meta as Options;
use AbbyJanke\BackpackMeta\app\Http\Models\Values;

trait Meta
{

  /**
   * Get all META options for the model.
   * @return void
   **/
    public function getMetaOptions()
    {
        $className = get_class($this->newInstance());
        return Options::where('model', $className)->get();
    }

    /**
     * Get all META options for the model.
     * @return void
     **/
    public function singleMetaOption($key)
    {
        return Options::where('key', $key)->first();
    }

    /**
     * Get the value of a single META option.
     * @return string
     **/
    public function meta($key)
    {
        $option = $this->singleMetaOption($key);
        $meta = Values::where('meta_id', $option->id)->first();
        if($meta) {
          return $meta->value;
        }
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $query = $this->newQueryWithoutScopes();

        // If the "saving" event returns false we'll bail out of the save and return
        // false, indicating that the save failed. This provides a chance for any
        // listeners to cancel save operations if validations fail or whatever.
        if ($this->fireModelEvent('saving') === false) {
            return false;
        }

        // If the model already exists in the database we can just update our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        if ($this->exists) {
            $saved = $this->isDirty() ?
                      $this->performUpdate($query) : true;
        }

        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else {
            $saved = $this->performInsert($query);

            if (! $this->getConnectionName() &&
              $connection = $query->getConnection()) {
                $this->setConnection($connection->getName());
            }
        }

        $newAttributes = Request::except(['_token', 'save_action', 'new_option']);
        foreach ($newAttributes as $key => $attribute) {
            if (!\Schema::hasColumn($this->getTable(), $key)) {
                $optionInfo = $this->singleMetaOption($key);
                if($this->meta($key)) {
                  $currentValue = Values::where('meta_id', $optionInfo->id)->first();
                  $currentValue->value = $attribute;
                  $currentValue->save();
                } else {
                  $newValue = Values::create([
                    'record_id' => $this->id,
                    'meta_id' => $optionInfo->id,
                    'value' => $attribute,
                  ]);
                }
            }
        }


        // If the model is successfully saved, we need to do a few more things once
        // that is done. We will call the "saved" method here to run any actions
        // we need to happen after a model gets successfully saved right here.
        if ($saved) {
            $this->finishSave($options);
        }

        return $saved;
    }
}
