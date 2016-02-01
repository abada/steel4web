<?php

Breadcrumbs::register('GestorDeLotes::dashboard', function ($breadcrumbs) {
	$breadcrumbs->push('Home', url('/'));
});

require __DIR__ . '/GestorDeLotes.php';