Laravel View Components
=======================

Provide a simple but effective view components system to Laravel, similar
to [view composers](https://laravel.com/docs/5.6/views#view-composers)
but in a different way : while a composer is called when the view is rendered,
with view component, the view is rendered by the component itself. So, the logic
is more tied to the view.

* [Installation](#installation)
* [Usage](#usage)

Installation
------------

With Composer:

```sh
composer require axn/laravel-view-components
```

In Laravel 5.5 the service provider is automatically included.
In older versions of the framework, simply add this service provider to the array
of providers in `config/app.php`:

```php
// config/app.php

'provider' => [
    //...
    Axn\ViewComponents\ServiceProvider::class,
    //...
];
```

Usage
-----

Create a class that extends `Axn\ViewComponents\ViewComponent` and write the logic
of your component in the `compose()` method. The `compose()` method must return
the view contents.

Example:

```php
namespace App\ViewComponents;

use Axn\ViewComponents\ViewComponent;
use App\Models\User;
use LaravelCollective\FormFacade as Form;

class UsersSelect extends ViewComponent
{
    protected function compose()
    {
        $users = User::pluck('username', 'id');

        return Form::select('user_id', $users, null, [
            'class' => 'form-control'
        ]);
    }
}
```

Then use the `@render` directive to render the component in a view:

```blade

<div class="form-group">
    {!! Form::label('user_id', 'Select a user:') !!}
    @render(App\ViewComponents\UsersSelect::class)
</div>
```

If you need to pass data to the component, do it like this:

```blade

<div class="form-group">
    {!! Form::label('user_id', 'Select a user:') !!}
    @render(App\ViewComponents\UsersSelect::class, [
        'selectedUser' => old('user_id', $currentUser->id)
    ])
</div>
```

And in the component:

```php
//...

class UsersSelect extends ViewComponent
{
    protected function compose()
    {
        $users = User::pluck('username', 'id');

        // $this->selectedUser value comes from the parent view
        return Form::select('user_id', $users, $this->selectedUser, [
            'class' => 'form-control'
        ]);
    }
}
```
