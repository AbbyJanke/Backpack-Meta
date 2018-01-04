# Backpack\Meta (AbbyJanke/Backpack-Meta)

A package designed to help create Meta options for the extending core functions of Backpack such as _users_ and other packages.

## Install

This package is currently in development and is not recommended for a production environment.

3. Publish the config file & run migrations.
```bash
$ php artisan vendor:publish --provider="Backpack\Meta\MetaServiceProvider" #publish config files and migrations
$ php artisan migrate #create the role and permission tables
```

4. Modify the Metable Models. With in the new `config/backpack/meta.php` configuration file you will need to list east of the models you wish to be accessible via the admin interface for creating meta fields. If you do not intend to use the admin interface then you and skip this step.

5. Use the following traits on your Controller
```php
<?php

namespace Backpack\PageManager\app\Http\Controllers\Admin;

use App\PageTemplates;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\PageManager\app\Http\Requests\PageRequest as StoreRequest;
use Backpack\PageManager\app\Http\Requests\PageRequest as UpdateRequest;
use Backpack\Meta\PanelTraits\Meta as MetaTrait; <!-- This One

class PageCrudController extends CrudController
{
    use MetaTrait; <!-- This one too
```

6. Use the following line within your `setup()` function.
```php
public function setup()
{
  $this->getMetaFields(); <!-- This one
}
```

7. Run the migration to have the database table we need:
```bash
php artisan migrate
```

8. [optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:
```bash
<li><a href="{{ url(config('backpack.base.route_prefix').'/meta') }}"><i class="fa fa-plus-square"></i> <span>Meta Options</span></a></li>
```

## Using with your CRUD

*Documentation for this is coming shortly*

## Security

If you discover any security related issues with this package, please email me@abbyjanke.com instead of using the issue tracker.
If you discover any security related issues with the Backpack core, please email hello@tabacitu.ro instead of using the issue tracker.
