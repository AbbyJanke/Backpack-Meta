<?php

namespace AbbyJanke\BackpackMeta\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Meta extends Model
{

    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'meta_options';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['key', 'display', 'helper', 'type', 'model'];

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
      if(!in_array('display', $this->attributes)) {
        $this->attributes['display'] = ucwords(str_replace('_', ' ', $this->attributes['key']));
      }
      parent::save();
    }
}
