<?php session_start();
require('config.php');
?>
<?php
if (!empty($_SESSION['id'])) {
$removeproject = $bdd->exec("DELETE FROM projects WHERE id =" . $_GET['project'] . "");
header('location: index.php');
} else {
  header('location: index.php');
}
?>
