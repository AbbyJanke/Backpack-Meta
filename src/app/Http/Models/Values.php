<?php

namespace AbbyJanke\BackpackMeta\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Values extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'meta_values';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['record_id', 'meta_id', 'value'];
}
