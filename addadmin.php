<?php session_start();
require('config.php') ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Ajouter un administrateur</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php'); ?>
<?php require('header.php'); ?>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="index.php">Accueil</a>
  <span class="breadcrumb-item active">Ajout d'administrateur</span>
</nav>
<?php
// Check if guys connected
  if (!empty($_SESSION['pseudo'])) {
    // Check if it's an admin
    if ($_SESSION['admin'] == "1") {
      echo '<form class="col-12 text-center" action="addadmin.php" method="post">
        <label for="addadmin">Pseudo de la personne à ajouter en tant qu\'administrateur:</label><br>
        <input id="addadmin" type="text" name="nickname">
        <input type="submit" value="Valider">
      </form>';
      echo '<form class="col-12 text-center pt-5" action="removeadmin.php?sendid=' . $_SESSION["id"] . '" method="post">
        <label for="removeadmin">Pseudo de l\'administrateur à supprimer:</label><br>
        <input id="removeadmin" type="text" name="nicknameadmin">
        <input type="submit" value="Valider">
      </form>';
    } else {
      header('location: index.php');
    }
  } else {
    header('location: index.php');
  }
?>
<?php
// If nickname input for add is not empty
if (!empty($_POST['nickname'])) {
  // Check if nickname exist
  $checkpseudo = $bdd->prepare('SELECT * FROM accounts WHERE user_name=:checkpseudo');
  $checkpseudo->execute(array(
    'checkpseudo' => $_POST['nickname']
  ));
  $checkpseudo = $checkpseudo->fetchAll();
  // If nickname exist add admin = 1
  if ($checkpseudo) {
    echo '<p class="colorgreen font-weight-bold text-center pt-2">'. $_POST["nickname"] . ' a bien étais ajouté.</p>';
    $passedadmin = $bdd->prepare('UPDATE accounts SET admin=1 WHERE user_name=:checkpseudo');
    $passedadmin->execute(array(
      'checkpseudo' => $_POST['nickname']
    ));
    header('Refresh: 1.5; URL=addadmin.php');
  }  else {
      echo '<p class="colorred font-weight-bold text-center pt-2">Cet Administrateur n\'existe pas.</p>';
      header('Refresh: 1.5; URL=addadmin.php'); 
    }
}
?>
