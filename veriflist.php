<?php
session_start();
require('config.php');
if (!empty($_POST['list_name'])) {
  $taskname = htmlspecialchars($_POST['list_name']);
  $newlist = $bdd->prepare("INSERT INTO lists (list, id_project) VALUES (:list, :idproject)");
  $newlist->execute(array(
    'list' => $taskname,
    'idproject' => $_GET['project']
  ));
  header("location: viewproject.php?project=" . $_GET['project'] . "");
}
?>