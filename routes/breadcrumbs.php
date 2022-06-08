<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for ('dashboard', function ($trail) {
    $trail->push(trans('validation.attributes.dashboard'), route('admin.dashboard.index'));
});

Breadcrumbs::for ('profile', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.profile'));
});

// Dashboard / Setting
Breadcrumbs::for ('setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.settings'));
});


// Dashboard / Email Setting
Breadcrumbs::for ('emailsetting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.emailsettings'));
});




// Dashboard / category
Breadcrumbs::for ('categories', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.categories'), route('admin.category.index'));
});

// Dashboard / categories / Add
Breadcrumbs::for ('categories/add', function ($trail) {
    $trail->parent('categories');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / categories / Edit
Breadcrumbs::for ('categories/edit', function ($trail) {
    $trail->parent('categories');
    $trail->push(trans('validation.attributes.edit'));
});

/* Product breadcrumbs */
// Dashboard / category
Breadcrumbs::for ('products', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.products'), route('admin.products.index'));
});

// Dashboard / dashboard
Breadcrumbs::for ('barcode', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.barcode'));
});

Breadcrumbs::for ('products/view', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('validation.attributes.view'));
});

Breadcrumbs::for ('products/add', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / products / Edit
Breadcrumbs::for ('products/edit', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('validation.attributes.edit'));
});
/* Product breadcrumbs ends */


// Dashboard / Shop
Breadcrumbs::for ('shops', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.shops'), route('admin.shop.index'));
});

// Dashboard / Shop / Add
Breadcrumbs::for ('shop/add', function ($trail) {
    $trail->parent('shops');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for ('shop/edit', function ($trail) {
    $trail->parent('shops');
    $trail->push(trans('validation.attributes.edit'));
});
// Dashboard / Shop / View
Breadcrumbs::for ('shop/view', function ($trail) {
    $trail->parent('shops');
    $trail->push(trans('validation.attributes.view'));
});


// Dashboard / User
Breadcrumbs::for ('administrators', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.administrators'), route('admin.administrators.index'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for ('administrators/add', function ($trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for ('administrators/edit', function ($trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for ('administrators/view', function ($trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / User
Breadcrumbs::for ('customers', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.customers'), route('admin.customers.index'));
});

// Dashboard / Shop / Add
Breadcrumbs::for ('customers/add', function ($trail) {
    $trail->parent('customers');
    $trail->push(trans('validation.attributes.add'));
});
// Dashboard / Shop / Edit
Breadcrumbs::for ('customers/edit', function ($trail) {
    $trail->parent('customers');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for ('customers/view', function ($trail) {
    $trail->parent('customers');
    $trail->push(trans('validation.attributes.view'));
});


// Dashboard / Deposit
Breadcrumbs::for ('deposit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.deposit'), route('admin.deposit.index'));
});

// Dashboard / deposit / Add
Breadcrumbs::for ('deposit/add', function ($trail) {
    $trail->parent('deposit');
    $trail->push(trans('validation.attributes.add'));
});
// Dashboard / deposit / Edit
Breadcrumbs::for ('deposit/edit', function ($trail) {
    $trail->parent('deposit');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / deposit / view
Breadcrumbs::for ('deposit/view', function ($trail) {
    $trail->parent('deposit');
    $trail->push(trans('validation.attributes.view'));
});


// Dashboard / Role
Breadcrumbs::for ('roles', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.roles'), route('admin.role.index'));
});

// Dashboard / Role / Add
Breadcrumbs::for ('role/add', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Role / Edit
Breadcrumbs::for ('role/edit', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Role / View
Breadcrumbs::for ('role/view', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Unit
Breadcrumbs::for ('units', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.units'), route('admin.unit.index'));
});

// Dashboard / Unit / Add
Breadcrumbs::for ('unit/add', function ($trail) {
    $trail->parent('units');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Unit / Edit
Breadcrumbs::for ('unit/edit', function ($trail) {
    $trail->parent('units');
    $trail->push(trans('validation.attributes.edit'));
});



// Dashboard / Sale
Breadcrumbs::for ('sales', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.sales'), route('admin.sale.index'));
});

// Dashboard / sale / Add
Breadcrumbs::for ('sale/add', function ($trail) {
    $trail->parent('sales');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / sale / Edit
Breadcrumbs::for ('sale/edit', function ($trail) {
    $trail->parent('sales');
    $trail->push(trans('validation.attributes.edit'));
});
Breadcrumbs::for ('sale/view', function ($trail) {
    $trail->parent('sales');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / pos / Add
Breadcrumbs::for ('pos/add', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.add'));
});

// Setting Module
Breadcrumbs::for ('site-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.site_settings'));
});

// Setting Module
Breadcrumbs::for ('email-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.email_settings'));
});



// Dashboard / Purchase
Breadcrumbs::for ('purchase', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.purchase'), route('admin.purchase.index'));
});


// Dashboard / Purchase / Add
Breadcrumbs::for ('purchase/add', function ($trail) {
    $trail->parent('purchase');
    $trail->push(trans('validation.attributes.add'));
});
// Dashboard / Purchase / Add
Breadcrumbs::for ('purchase/view', function ($trail) {
    $trail->parent('purchase');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Purchase / Edit
Breadcrumbs::for ('purchase/edit', function ($trail) {
    $trail->parent('purchase');
    $trail->push(trans('validation.attributes.edit'));
});

Breadcrumbs::for ('sms-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.sms_settings'));
});

// Dashboard / SMS Setting
Breadcrumbs::for ('smssetting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.smssetting'));
});
// Dashboard / WhatsApp SMS Setting
Breadcrumbs::for ('whatsapp-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.whatsapp-setting'));
});

// Dashboard / Payment Setting
Breadcrumbs::for ('payment-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.payment_settings'));
});
// Dashboard / Stock
Breadcrumbs::for ('stocks', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.stocks'), route('admin.stock.index'));
});

// Dashboard / Stock / Add
Breadcrumbs::for ('stock/add', function ($trail) {
    $trail->parent('stocks');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Stock / Edit
Breadcrumbs::for ('stock/edit', function ($trail) {
    $trail->parent('stocks');
    $trail->push(trans('validation.attributes.edit'));
});
// Dashboard / Report
Breadcrumbs::for ('sales-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.sales-report'),route('admin.sales-report.index'));
});
Breadcrumbs::for ('purchases-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.purchases-report'),route('admin.purchases-report.index'));
});
Breadcrumbs::for ('stock-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.stock-report'),route('admin.stock-report.index'));
});

// Dashboard / Tax
Breadcrumbs::for ('taxs', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.taxs'), route('admin.tax.index'));
});

// Dashboard / Tax / Add
Breadcrumbs::for ('tax/add', function ($trail) {
    $trail->parent('taxs');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Tax / Edit
Breadcrumbs::for ('tax/edit', function ($trail) {
    $trail->parent('taxs');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / language
Breadcrumbs::for ('language', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.language'), route('admin.language.index'));
});

// Dashboard / language / Add
Breadcrumbs::for ('language/add', function ($trail) {
    $trail->parent('language');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / language / Edit
Breadcrumbs::for ('language/edit', function ($trail) {
    $trail->parent('language');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / addons
Breadcrumbs::for ('addons', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.addons'), route('admin.addons.index'));
});

// Dashboard / addons / Add
Breadcrumbs::for ('addons/add', function ($trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / addons / Edit
Breadcrumbs::for ('addons/edit', function ($trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / addons / View
Breadcrumbs::for ('addons/view', function ($trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.view'));
});

// Setting purchasekey-setting Module
Breadcrumbs::for ('purchasekey-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.purchasekey_settings'));
});
