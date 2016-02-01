<?php

Breadcrumbs::register('GestorDeLotes::conjuntos', function ($breadcrumbs) {
	$breadcrumbs->parent('GestorDeLotes::dashboard');
	$breadcrumbs->push('Conjuntos', url('gestordelotes/conjuntos'));
});

Breadcrumbs::register('GestorDeLotes::pecas', function ($breadcrumbs) {
	$breadcrumbs->parent('GestorDeLotes::dashboard');
	$breadcrumbs->push('Peças', url('gestordelotes/pecas'));
});