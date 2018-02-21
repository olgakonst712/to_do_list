<?php 
// Fichier   request   en   php   (request.php)   qui   comprendra   vos   fonctions d'appel   à   la   base   de   données.   Et   dans   lequel   seront   inclus   dans   l'ordre: config.php   et   connexion.php.   Je   vous   invite   à   revoir   comment   on   a   fait pour   inclure   des   fichiers   php.   Vous   ferez   juste   un   var_dump   pour vérifier   que   vous   récupérez   bien   les   bonnes   données.   On   reviendra   sur ce   fichier   plus   tard   lors   de   la   mise   en   place   de   la   communication   en AJAX.
include_once 'config.php';
include_once 'connexion.php';


//////////////////////////// $_POST ACTIONS /////////////////////////////////
function catchPost()
{
	if (!empty($_POST)) {
		if (isset($_POST['action'])&&!empty($_POST['action'])) {
			$action = $_POST['action'];
			//sendMail($action);
			if (function_exists($action())) $action();
		}
	}
}
function sendMail($action){
	$to      = 'aldealdo@gmail.com';
	$subject = 'Changement dans la Todolist';
	$message = 'Salut!<br>Une modification dans la TodoList a été detectée: <br><pre>'.$action.'</pre>';
	$headers = 'From: webmaster@todolist.dev' . "\r\n" .
	'Reply-To: webmaster@todolist.dev' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
}
/////////// Action and validation functions
function add()
{
	if (isset($_POST['task_title'],$_POST['task_description'],$_POST['task_created_on'],$_POST['task_end'])){
		try {
			return addTask();
		} catch (Exception $e) {
			return $e;
		}
	 } else {
	 	return "Certains champs sont vides, veuillez les compléter";
	 }
}
function update()
{
	if (isset($_POST['task_id'],$_POST['task_title'],$_POST['task_description'],$_POST['task_created_on'],$_POST['task_end'])){
		try {
			return updateTask();
		} catch (Exception $e) {
			return $e;
		}
	 } else {
	 	return "Certains champs sont vides, veuillez les compléter";
	 }
}
function get()
{
	if (isset($_POST['task_id'])) {
		try {
			return getTask();
		} catch (Exception $e) {
			return $e;
		}
	 }
}
function complete()
{
	if (isset($_POST['task_id'])) {
		try {
			return completeTask();
		} catch (Exception $e) {
			return $e;
		}
	 }
}
function uncomplete()
{
	if (isset($_POST['task_id'])) {
		try {
			return unCompleteTask();
		} catch (Exception $e) {
			return $e;
		}
	 }
}
function delete()
{
	if (isset($_POST['task_id'])) {
		try {
			return deleteTask();
		} catch (Exception $e) {
			return $e;
		}
	 }
}
/////////// Database write functions
function addTask()
{
	global $bdd;
	$sql = "INSERT INTO tasks (task_title, task_description, task_created_on, task_end) VALUES (:title, :description, :created, :deadline);";
	$sth = $bdd->prepare($sql);
	try {
		$sth->execute(array(
			"title" => $_POST['task_title'],
			"description" => $_POST['task_description'],
			"created" => $_POST['task_created_on'],
			"deadline" => $_POST['task_end']
		));
		return "success";
	} catch (Exception $e) {
		return $e;
	}
}

function updateTask()
{
	global $bdd;

	$sql = "
	UPDATE tasks
	SET task_title = :title, task_description = :description, task_created_on = :created, task_end = :deadline
	WHERE task_id = :id";
	$sth = $bdd->prepare($sql);
	try {
		$sth->execute(array(
			"id" => $_POST['task_id'],
			"title" => $_POST['task_title'],
			"description" => $_POST['task_description'],
			"created" => $_POST['task_created_on'],
			"deadline" => $_POST['task_end']
		));
		return "success";
	} catch (Exception $e) {
		return $e;
	}
}

function completeTask()
{
	global $bdd;
	$sql = "UPDATE tasks SET `task_ended_on`=:finished WHERE `task_id` = :id;";
	$sth = $bdd->prepare($sql);
	try {
		$sth->execute(array(
			"id" => $_POST['task_id'],
			"finished" => time()
		));
	} catch (Exception $e) {
		return $e;
	}
	return "success";
}
function unCompleteTask()
{
	global $bdd;
	$sql = "UPDATE tasks SET `task_ended_on`=null WHERE `task_id` = :id;";
	$sth = $bdd->prepare($sql);
	try {
		$sth->execute(array(
			"id" => $_POST['task_id'],
		));
	} catch (Exception $e) {
		return $e;
	}
	return "success";
}

function deleteTask()
{
	global $bdd;
	$sql = "DELETE FROM tasks WHERE task_id=:id;";
	$sth = $bdd->prepare($sql);
	try {
		$sth->execute(array(
			"id" => $_POST['task_id']
		));
	} catch (Exception $e) {
		return $e;
	}
	return "success";
}

//////////////////////////// $_GET OPTIONS /////////////////////////////////
function catchGet()
{
	$filter = "all";
	if (isset($_GET)&&!empty($_GET)) {

		if (
			isset($_GET['filter'])
				&&
			($_GET['filter']=='todo'||$_GET['filter']='done'||$_GET['filter']=='late'||$_GET['filter']='all'))
		{

		}
	}
	return getTasks($filter);
}
/////////// filtered request phrase
function getFilterRequest($filter){
	$filters = array(
		"all"  => '',
		"todo" => ' WHERE `task_ended_on` IS NULL',
		"done" => ' WHERE `task_ended_on` IS NOT NULL AND `task_ended_on` < `task_end`',
		"late" => ' WHERE `task_ended_on` IS NOT NULL AND `task_ended_on` > `task_end`'
	);
	return $filters[$filter];
}

/////////// Database read functions
function getTasks($filter)
{
	global $bdd;
	$filter = getFilterRequest($filter);
	$sql = 'SELECT * FROM tasks'.$filter;
	$sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute();
	return $sth->fetchAll();
}




$answer['reaction'] = catchPost();
$answer['tasks'] = catchGet();
echo json_encode($answer);
 ?>