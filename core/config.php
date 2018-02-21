<?php 
// Fichier   de   config   php   (config.php)   qui   comprendra   un   tableau   en   php
// avec   une   clé   database   qui   aura   comme   valeur   un   tableau   qui comprendra   à   son   tour   des   clés   valeurs.   Les   clés   étant: host,user,password,dbname.

$config = array(
	'database' => array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => 'root',
		'dbname' => 'todo_app'
	)
);

function dump($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
};

function dd($var){
	dump($var);
	die();
};

 ?>