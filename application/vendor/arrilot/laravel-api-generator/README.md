[![Total Downloads](https://img.shields.io/packagist/dt/Arrilot/laravel-api-generator.svg?style=flat)](https://packagist.org/packages/Arrilot/laravel-api-generator)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/Arrilot/laravel-api-generator/master.svg?style=flat)](https://scrutinizer-ci.com/g/Arrilot/laravel-api-generator/)
[![MIT License](https://img.shields.io/packagist/l/Arrilot/laravel-api-generator.svg?style=flat)](https://packagist.org/packages/Arrilot/laravel-api-generator)

# Laravel Api Generator

*Two simple tools for building REST APIs with fractal: console generator and API skeleton*

## Introduction

This package provides two features

1. Console generator which creates Controller, Fractal Transformer and routes in a single command.

2. Basic REST API skeleton that can be really helpful if you need something standard. It's 100% optional.

If you do not use Fractal for your transformation layer, this package is probably not the right choice for you.

## Installation

1) Run ```composer require arrilot/laravel-api-generator```

2) Register a service provider in the `app.php` configuration file

```php
<?php

'providers' => [
    ...
    'Arrilot\Api\ServiceProvider',
],
?>
```

3) Copy basic folder structure to app/Api ```cp -R vendor/arrilot/laravel-api-generator/templates/Api app/Api``` and check what you got there.
If you need you can use different paths later.


## Usage

### Generator

The only console command that is added is ```artisan make:api <ModelName>```.

Imagine you need to create a rest api to list/create/update etc users from users table.
To achieve that you need to do lots of boilerplate operations - create controller, transformer, set up needed routes.

```php artisan make:api User``` does all the work for you.

1) You may have noticed that after installation you already have a routes file `app/Api/routes.php` which looks like that:

```php
<?php

Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Api\Controllers'], function () {
    //
});

```

Feel free to change it if you like.

The generator adds ```Route::resource('users', 'UserController');``` to the end of this file.

```php
<?php

Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Api\Controllers'], function () {
    //
    Route::resource('users', 'UserController');
});

```

As you can see it's smart enough to detect some route groups and treat this situation properly.

2) Then the generator creates a controller that extends base api controller.

```php
<?php namespace App\Api\Controllers;

use App\User;
use App\Api\Transformers\UserTransformer;

class UserController extends Controller
{
    /**
     * Eloquent model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function model()
    {
        return new User;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new UserTransformer;
    }
}

```
You can customize this stub as much as you want.

3) Finally the generator creates a fractal Transformer

```php
<?php namespace App\Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Resource key.
     *
     * @var string
     */
    protected $resourceKey = null;
    
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(User $item)
    {
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}

```

This stub is customizable too.

### Skeleton

You may have noticed that controller which has just been generated includes two public methods - `model()` and `transformer()`
That's because those methods are the only thing that you need in your controller to set up a basic REST API if you use the Skeleton.

The list of routes that are available out of the box:

1. `GET api/v1/users`
2. `GET api/v1/users/{id}`
3. `POST  api/v1/users`
4. `PUT api/v1/users/{id}`
5. `DELETE  api/v1/users/{id}`

Request and respone format is json
Fractal includes are supported via $_GET['include'].
Validation rules for create and update can be set by overwriting `rulesForCreate` and `rulesForUpdate` in your controller.

This skeleton is not a silver bullet but in many cases it can be either exactly what you need or can be used as a decent starting point for your api.

You can check https://github.com/Arrilot/laravel-api-generator/blob/master/src/Skeleton/BaseController.php for more info.

If you don't like the Skeleton just stop inheriting it in the base controller -  `Api\Controllers\Controller` and overwrite the controller stub in your config to remove  `model()` and `transformer()` methods.


### Configuration

All paths and generator's stubs are configurable.

https://github.com/Arrilot/laravel-api-generator/blob/master/src/config/config.php


