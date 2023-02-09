<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\Request;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

$modelsArray = ['users', 'customer', 'invoice', 'product-master', 'setting','banks','invoice-performa'];
$breadCrumbsArray = ['index', 'create', 'show', 'edit'];

foreach ($modelsArray as $model) {
    foreach ($breadCrumbsArray as $breadcrumb) {
        Breadcrumbs::for("$model.$breadcrumb", function ($trail, $id = null) use ($model, $breadcrumb) {
            switch ($breadcrumb) {
                case 'index':
                    $trail->parent('dashboard');
                    $trail->push(ucfirst($model), route("$model.$breadcrumb"));
                    break;
                case 'create':
                    $trail->parent("$model.index");
                    $trail->push("New " . ucfirst($model), route("$model.$breadcrumb"));
                    break;
                case 'show':
                    $trail->parent("$model.index");
                    $trail->push("View " . ucfirst($model), route("$model.$breadcrumb"));
                    break;
                case 'edit':
                    $trail->parent("$model.index");
                    $trail->push("Edit " . ucfirst($model), route("$model.$breadcrumb", [$id]));
                    break;
            }
        });
    }
}

Breadcrumbs::for('showInv', function ($trail, $id) {
    $trail->parent('invoice.index');
    $trail->push('View Invoice', route('showInv', [$id]));
});

Breadcrumbs::for('inv-payment.create', function ($trail, $invId) {
    dd('dd');;
});
