<?php session_start();
require('config.php');
?>
<?php
// Check if user connected
if (!empty($_SESSION['id'])) {
  // Remove project by id of project
$removeproject = $bdd->exec("DELETE FROM projects WHERE id =" . $_GET['project'] . "");
header('location: index.php');
} else {
  header('location: index.php');
}
?>
