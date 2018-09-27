<?php
session_start();
require('config.php');
if (!empty($_SESSION['id'])) {
// Take the id for deconnect the good guys
  $idtake = $_SESSION['id'];
  $account = $bdd->exec('UPDATE accounts SET verif_connect=0 WHERE id=' . $idtake . '');
  // Stop session
  session_destroy();
  header('location: index.php');
} else {
  header('location: index.php');
}
?>
