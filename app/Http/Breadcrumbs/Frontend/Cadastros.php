<?php

Breadcrumbs::register('Users::index', function ($breadcrumbs) {
    $breadcrumbs->parent('GestorDeLotes::dashboard');
    $breadcrumbs->push(trans('Usuários'), url('admin/access/users'));
});

Breadcrumbs::register('Users::create', function ($breadcrumbs) {
    $breadcrumbs->parent('Users::index');
    $breadcrumbs->push(trans('Criar Usuário'), url('admin/access/users/create'));
});

Breadcrumbs::register('Users::edit', function ($breadcrumbs) {
    $breadcrumbs->parent('Users::index');
    $breadcrumbs->push(trans('Editar Usuário'), url('admin/access/users/create'));
});

Breadcrumbs::register('Cadastros::clientes', function ($breadcrumbs) {
	$breadcrumbs->parent('GestorDeLotes::dashboard');
	$breadcrumbs->push('Clientes', url('clientes'));
});

Breadcrumbs::register('Cadastros::cliente', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::clientes');
	$breadcrumbs->push('Perfil', url('cliente/'.$id));
});

Breadcrumbs::register('Cadastros::cliente.cadastro', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::clientes');
	$breadcrumbs->push('Cadastrar', url('cliente.cadastro'));
});

Breadcrumbs::register('Cadastros::cliente.editar', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::clientes');
    $breadcrumbs->push(trans('Editar'), url('cliente/editar/'.$id));
});

Breadcrumbs::register('Cadastros::contatos', function ($breadcrumbs) {
	$breadcrumbs->parent('GestorDeLotes::dashboard');
	$breadcrumbs->push('Contatos', url('contatos'));
});

Breadcrumbs::register('Cadastros::contato', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::contatos');
	$breadcrumbs->push('Perfil', url('contato/'.$id));
});

Breadcrumbs::register('Cadastros::contato.cadastro', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::contatos');
	$breadcrumbs->push('Cadastrar', url('contato.cadastro'));
});

Breadcrumbs::register('Cadastros::contato.editar', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::contatos');
    $breadcrumbs->push(trans('Editar'), url('contato/editar/'.$id));
});

Breadcrumbs::register('Cadastros::obras', function ($breadcrumbs) {
	$breadcrumbs->parent('GestorDeLotes::dashboard');
	$breadcrumbs->push('Obras', url('obras'));
});

Breadcrumbs::register('Cadastros::obra.cadastro', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::obras');
	$breadcrumbs->push('Cadastrar', url('obra.cadastro'));
});

Breadcrumbs::register('Cadastros::obra.editar', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::obras');
    $breadcrumbs->push(trans('Editar'), url('obras/'.$id));
});

Breadcrumbs::register('Cadastros::obra', function ($breadcrumbs, $name, $id) {
	$breadcrumbs->parent('Cadastros::obras');
    $breadcrumbs->push(trans($name), url('obra/'.$id));
});

Breadcrumbs::register('Cadastros::etapa.cadastro', function ($breadcrumbs,$name, $id) {
	$breadcrumbs->parent('Cadastros::obra',$name, $id);
	$breadcrumbs->push('Cadastrar Etapa', url('etapa/cadastro/'.$id));
});

Breadcrumbs::register('Cadastros::etapa.editar', function ($breadcrumbs, $id, $name, $obraID) {
	$breadcrumbs->parent('Cadastros::obra', $name, $obraID);
    $breadcrumbs->push(trans('Editar Etapa'), url('etapa/editar/'.$id));
});

Breadcrumbs::register('Cadastros::etapa', function ($breadcrumbs, $name2, $name, $obraID) {
	$breadcrumbs->parent('Cadastros::obra', $name, $obraID);
    $breadcrumbs->push(trans($name2), url('obra/'.$obraID.'#etapas'));
});

Breadcrumbs::register('Cadastros::subetapa.cadastro', function ($breadcrumbs,$name, $id, $nameE, $obraID) {
	$breadcrumbs->parent('Cadastros::etapa',$nameE, $name, $obraID);
	$breadcrumbs->push('Cadastrar Subetapa', url('etapa/cadastro/'.$id));
});

Breadcrumbs::register('Cadastros::subetapa.editar', function ($breadcrumbs, $name, $id, $nameE, $obraID, $subID) {
	$breadcrumbs->parent('Cadastros::etapa',$nameE, $name, $obraID);
    $breadcrumbs->push(trans('Editar Subetapa'), url('subetapa/editar/'.$subID));
});

Breadcrumbs::register('Cadastros::contato.tipos', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::contatos');
	$breadcrumbs->push('Categorias', url('contato/tipos'));
});

Breadcrumbs::register('Cadastros::contato.tipo.cadastro', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::contato.tipos');
	$breadcrumbs->push('Cadastro', url('contato/tipo/cadastro'));
});

Breadcrumbs::register('Cadastros::contato.tipo.editar', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::contato.tipos');
	$breadcrumbs->push('Editar', url('contato/tipo/editar.'.$id));
});

Breadcrumbs::register('Cadastros::subetapa.tipos', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::obras');
	$breadcrumbs->push('Tipos de Subetapas', url('subetapa/tipos'));
});

Breadcrumbs::register('Cadastros::subetapa.tipo.cadastro', function ($breadcrumbs) {
	$breadcrumbs->parent('Cadastros::subetapa.tipos');
	$breadcrumbs->push('Cadastro', url('subetapa/tipo/cadastro'));
});

Breadcrumbs::register('Cadastros::subetapa.tipo.editar', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('Cadastros::subetapa.tipos');
	$breadcrumbs->push('Editar', url('subetapa/tipo/editar.'.$id));
});




