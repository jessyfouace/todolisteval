<?php
session_start();
require('config.php');
// Check if user connected
if (!empty($_SESSION['id'])) {
  // Check if input is no't empty
  if (!empty($_POST['list_name'])) {
    // Add security of input
    $taskname = htmlspecialchars(addslashes(strip_tags($_POST['list_name'])));
    // Insert new list
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
