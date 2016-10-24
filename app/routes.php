<?php
	
	$app->get(
		'/groups',
		'Compta\Controller\APIControllerRead::getGroups'
	);
	
	$app->get(
		'/group/{group_id}/users',
		'Compta\Controller\APIControllerRead::getUsers'
	);
	
	$app->get(
		'/group/{group_id}/depenses',
		'Compta\Controller\APIControllerRead::getDepenses'
	);
	
	$app->post(
		'/admin/group',
		'Compta\Controller\APIControllerCreate::addGroup'
	);
	
	$app->post(
		'/admin/user',
		'Compta\Controller\APIControllerCreate::addUser'
	);
	
	$app->post(
		'/admin/depense',
		'Compta\Controller\APIControllerCreate::addDepense'
	);
	
	$app->delete(
		'/admin/group/{id}',
		'Compta\Controller\APIControllerDelete::deleteGroup'
	);
	
	$app->delete(
		'/admin/user/{id}',
		'Compta\Controller\APIControllerDelete::deleteUser'
	);
	
	$app->delete(
		'/admin/depense/{id}',
		'Compta\Controller\APIControllerDelete::deleteDepense'
	);
	
?>
