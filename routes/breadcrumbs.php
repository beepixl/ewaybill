<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > Users
Breadcrumbs::for('users.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users.index'));
});

// Dashboard > User > Create
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users.index');
    $trail->push('Create New User', route('users.create'));
});

// Dashboard > User > Create
Breadcrumbs::for('users.edit', function ($trail, $id) {
    $trail->parent('users.index');
    $trail->push('Update User', route('users.edit', [$id]));
});


Breadcrumbs::for('setting.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Setting', route('setting.index'));
});

