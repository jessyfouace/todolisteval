<?php session_start();
require('config.php');
?>
<?php
// Check if user connected
if (!empty($_SESSION['id'])) {
  // Remove task from id of the task
  $removeproject = $bdd->exec("DELETE FROM tasklist WHERE id =" . $_GET['idtask'] . "");
  header('location: viewtask.php?list=' . $_GET['idlist'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '');
} else {
  header('location: index.php');
}
?>
