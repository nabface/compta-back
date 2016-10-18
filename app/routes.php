<?php
	
	$app->get(
		'/api/group/{group_id}/depenses',
		'Compta\Controller\APIController::getDepenses'
	)->bind('api_depenses');
	
	$app->get(
		'/api/group/{group_id}/users',
		'Compta\Controller\APIController::getUsers'
	)->bind('api_users');
	
	$app->post(
		'/api/group',
		'Compta\Controller\APIController::addGroup'
	)->bind('api_group_add');
	
	$app->post(
		'/api/depense',
		'Compta\Controller\APIController::addDepense'
	)->bind('api_depense_add');
	
	$app->post(
		'/api/user',
		'Compta\Controller\APIController::addUser'
	)->bind('api_user_add');
	
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
