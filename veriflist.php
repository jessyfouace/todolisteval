<?php
session_start();
require('config.php');
if (!empty($_SESSION['id'])) {
  if (!empty($_POST['list_name'])) {
    $taskname = htmlspecialchars(addslashes(strip_tags($_POST['list_name'])));
    $newlist = $bdd->prepare("INSERT INTO lists (list, id_project, id_creator) VALUES (:list, :idproject, :idcreator)");
    $newlist->execute(array(
      'list' => $taskname,
      'idproject' => $_GET['project'],
      'idcreator' => $_SESSION['id']
    ));
    header("location: viewproject.php?project=" . $_GET['project'] . "");
  }
} else {
  header('lcoation: index.php');
}
?>
