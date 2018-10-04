<?php
session_start();
require('config.php');
// Check if the remove input is no't empty
if (!empty($_POST['nicknameadmin'])) {
  // If the value input is different if my nickname (security)
  if ($_POST['nicknameadmin'] !== "Rayteur") {
    // Verify if the admin is on the bdd
    $checkpseudo = $bdd->prepare('SELECT * FROM accounts WHERE user_name=:checkpseudo');
    $checkpseudo->execute(array(
      'checkpseudo' => $_POST['nicknameadmin']
    ));
    $checkpseudo = $checkpseudo->fetchAll();
    // If the admin is on the bdd
    if ($checkpseudo) {
      // remove admin
      $removedadmin = $bdd->prepare('UPDATE accounts SET admin=NULL WHERE user_name=:checkpseudo');
      $removedadmin->execute(array(
        'checkpseudo' => $_POST['nicknameadmin']
      ));
      header('location: addadmin.php');
    }
  } else {
    // if value is Rayteur, remove the admin because he try to remove "fondator"
    $removedadmin = $bdd->prepare('UPDATE accounts SET admin=NULL WHERE id=:checkid');
    $removedadmin->execute(array(
      'checkid' => $_GET['sendid']
    ));
    $_SESSION['admin'] = "0";
    header('location: index.php');
  }
}
?>
