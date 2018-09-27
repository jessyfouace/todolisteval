<?php session_start();
require('config.php') ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Ajouter une tâche</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">

<?php require('doctype.php'); ?>
<?php require('header.php'); ?>
<?php
if (!empty($_SESSION['id'])) {
  $viewconnect = $bdd->prepare('SELECT * FROM lists WHERE id_project = :getid');
  $viewconnect->execute(array(
    'getid' => $_GET['project']
  ));
  $viewconnect = $viewconnect->fetch();
  if ($_GET['creator'] == $_SESSION['id'] || $_SESSION['id'] == "16") {
    echo '<nav class="breadcrumb">
      <a class="breadcrumb-item" href="index.php">Accueil</a>
      <a class="breadcrumb-item" href="viewproject.php?project=' . $_GET['project'] . '">Voir projet</a>
      <a class="breadcrumb-item" href="viewtask.php?list=' . $_GET['idlist'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '">Listes projet</a>
      <span class="breadcrumb-item active">Ajout de tâche</span>
    </nav>';
    echo  "<form class='col-12 text-center' action='addtask.php?idlist=" . $_GET['idlist'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . "' method='post'>
            <label for='nametask'>Nom de la tâche: (max 20 caractères)</label><br>
            <input id='nametask' type='text' name='taskname'><br>
            <label for='tasklimit'>Date limite de la tâche: (format 01/01/2018)</label><br>
            <input id='tasklimit' type='text' name='tasklimit'><br>
            <input type='submit' value='Envoyer'>
          </form>";
  }
} else {
  header('location: index.php');
}
require('script.php'); ?>

<?php

if (!empty($_POST['taskname']) AND !empty($_POST['tasklimit'])) {
  $taskname = htmlspecialchars($_POST['taskname']);
  $tasklimit = htmlspecialchars($_POST['tasklimit']);
  if (preg_match("#[0-3]{1}[0-9]{1}+/[0-1]{1}[0-9]{1}+/[0-9]{4}$#", $tasklimit)) {
    $newtask = $bdd->prepare("INSERT INTO tasklist (task_name, task_limit, checked, id_task, creator_project) VALUES (:name, :limitdate, :checked, :idlist, :creator_project)");
    $newtask->execute(array(
      'name' => $taskname,
      'limitdate' => $tasklimit,
      'checked' => 0,
      'idlist' => $_GET['idlist'],
      'creator_project' => $_GET['project']
    ));
    header('location: viewtask.php?list=' . $_GET['idlist'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '');
  }
}

?>
