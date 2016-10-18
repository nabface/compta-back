<?php
	
	$app->get(
		'/read/group/{group_id}/depenses',
		'Compta\Controller\APIControllerRead::getDepenses'
	)->bind('read_depenses');
	
	$app->get(
		'/read/group/{group_id}/users',
		'Compta\Controller\APIControllerRead::getUsers'
	)->bind('read_users');
	
	$app->post(
		'/add/group',
		'Compta\Controller\APIControllerCreate::addGroup'
	)->bind('add_group');
	
	$app->post(
		'/add/depense',
		'Compta\Controller\APIControllerCreate::addDepense'
	)->bind('add_depense');
	
	$app->post(
		'/add/user',
		'Compta\Controller\APIControllerCreate::addUser'
	)->bind('add_user');
	
	$app->delete(
		'/api/group/{id}',
		'Compta\Controller\APIController::deleteGroup'
	)->bind('api_group_delete');
	
	$app->delete(
		'/api/depense/{id}',
		'Compta\Controller\APIController::deleteDepense'
	)->bind('api_depense_delete');
	
	$app->delete(
		'/api/user/{id}',
		'Compta\Controller\APIController::deleteUser'
	)->bind('api_user_delete');
	
?>
