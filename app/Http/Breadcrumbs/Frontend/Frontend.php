<?php

Breadcrumbs::register('GestorDeLotes::dashboard', function ($breadcrumbs) {
	$breadcrumbs->push('Home', url('/'));
});

Breadcrumbs::register('Importador::index', function ($breadcrumbs) {
    $breadcrumbs->parent('GestorDeLotes::dashboard');
    $breadcrumbs->push(trans('Importador'), route('importador'));
});

Breadcrumbs::register('Apontador::index', function ($breadcrumbs) {
    $breadcrumbs->parent('GestorDeLotes::dashboard');
    $breadcrumbs->push(trans('Apontador'), route('apontador'));
});

Breadcrumbs::register('Romaneios::index', function ($breadcrumbs) {
    $breadcrumbs->parent('GestorDeLotes::dashboard');
    $breadcrumbs->push(trans('Romaneios'), url('romaneios'));
});

require __DIR__ . '/GestorDeLotes.php';
require __DIR__ . '/Cadastros.php';