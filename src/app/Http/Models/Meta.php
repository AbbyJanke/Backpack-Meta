<?php

namespace AbbyJanke\BackpackMeta\app\Http\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

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
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'address'    => 'array',
        'table'      => 'object',
        'fake_table' => 'object',
    ];

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
