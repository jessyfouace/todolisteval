<?php
session_start();
require('config.php');
if (!empty($_POST['nicknameadmin'])) {
  if ($_POST['nicknameadmin'] !== "Rayteur") {
    $checkpseudo = $bdd->prepare('SELECT * FROM accounts WHERE user_name=:checkpseudo');
    $checkpseudo->execute(array(
      'checkpseudo' => $_POST['nicknameadmin']
    ));
    $checkpseudo = $checkpseudo->fetchAll();
    if ($checkpseudo) {
      $removedadmin = $bdd->prepare('UPDATE accounts SET admin=NULL WHERE user_name=:checkpseudo');
      $removedadmin->execute(array(
        'checkpseudo' => $_POST['nicknameadmin']
      ));
      header('location: addadmin.php');
    }
  } else {
    $removedadmin = $bdd->prepare('UPDATE accounts SET admin=NULL WHERE id=:checkid');
    $removedadmin->execute(array(
      'checkid' => $_GET['sendid']
    ));
    $_SESSION['admin'] = "0";
    header('location: index.php');
  }
}
?>
