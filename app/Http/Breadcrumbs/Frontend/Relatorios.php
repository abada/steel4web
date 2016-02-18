<?php  

Breadcrumbs::register('Relatorios::index', function ($breadcrumbs) {
    $breadcrumbs->parent('GestorDeLotes::dashboard');
    $breadcrumbs->push(trans('Relatorios'), url('relatorios'));
});

Breadcrumbs::register('Relatorios::obras', function ($breadcrumbs) {
    $breadcrumbs->parent('Relatorios::index');
    $breadcrumbs->push(trans('Obras'), url('relatorios/obras'));
});