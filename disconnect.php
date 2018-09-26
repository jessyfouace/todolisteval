<?php
session_start();
require('config.php');
// Take the id for deconnect the good guys
  $idtake = $_SESSION['id'];
  $create = $bdd->exec('UPDATE newacc SET verif_connect=1 WHERE id=' . $idtake . '');
  // Stop session
  session_destroy();
  header('location: index.php');
?>
