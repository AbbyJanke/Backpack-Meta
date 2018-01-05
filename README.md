# AbbyJanke/BackpackMeta

A package designed to help create Meta options for the extending core functions of Backpack such as _users_ and other packages.

## Install

This package is currently in development and is not recommended for a production environment.

1. In your terminal:
```
$ composer require abbyjanke/backpackmeta
```

2. Publish the config file & run migrations.
```bash
$ php artisan vendor:publish --provider="AbbyJanke\BackpackMeta\MetaServiceProvider" #publish config files and migrations
$ php artisan migrate #create the role and permission tables
```

3. Within the new `config/backpack/meta.php` configuration file you will need to set a list of all models you wish to be accessible via the admin interface for meta fields.
If you do not intend to use the admin interface then you can skip this step. Example:
```php
'models' => [
    'App\Models\Monster',
    'App\User'
],
```

4. Use the following traits on your Controller
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MonsterRequest as StoreRequest;
use App\Http\Requests\MonsterRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use AbbyJanke\BackpackMeta\PanelTraits\Meta as MetaTrait; // <!-------------- This One

class MonsterCrudController extends CrudController
{
    use MetaTrait; // <!-------------- This one too

    public function setup()
    {
      $this->getMetaFields(); // <!-------------- And finally this one
    }
```

4. Run the migration to have the database table we need:
```bash
php artisan migrate
```

5. [optional] Add a menu item for it in `resources/views/vendor/backpack/base/inc/sidebar.blade.php`:
```bash
<li><a href="{{ url(config('backpack.base.route_prefix').'/meta') }}"><i class="fa fa-plus-square"></i> <span>Meta Options</span></a></li>
```

## Not Using Backpack\CRUD?

*Documentation for this is coming shortly*

## Security

If you discover any security related issues with this package, please email me@abbyjanke.com instead of using the issue tracker.
If you discover any security related issues with the Backpack core, please email hello@tabacitu.ro instead of using the issue tracker.
