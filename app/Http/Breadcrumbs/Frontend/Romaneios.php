<?php 

Breadcrumbs::register('Romaneios::index', function ($breadcrumbs) {
	$breadcrumbs->parent('GestorDeLotes::dashboard');
	$breadcrumbs->push(trans('Romaneios'), url('romaneios'));
});

Breadcrumbs::register('Romaneios::criar', function ($breadcrumbs) {
    $breadcrumbs->parent('Romaneios::index');
    $breadcrumbs->push(trans('Criar'), url('romaneios/criar'));
});

Breadcrumbs::register('Romaneios::perfil', function ($breadcrumbs, $id, $name) {
    $breadcrumbs->parent('Romaneios::index');
    $breadcrumbs->push(trans($name), url('romaneios/perfil/'.$id));
});

 ?>