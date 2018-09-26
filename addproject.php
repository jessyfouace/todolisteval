<?php session_start();
require('config.php') ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Ajout projet</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php'); ?>
<?php require('header.php'); ?>

<form class="text-center" action="addproject.php" method="post">
  <label for="titleproject">Titre du projet:</label><br>
  <input class="addprojectinput" id="titleproject" type="text" name="titleproject"><br>
  <label for="descproject">Description du projet:</label><br>
  <textarea id="descproject" name="descproject" rows="6" cols="30" placeholder="..."></textarea><br>
  <label for="deadlineproject">Date limite du projet:</label><br>
  <input class="addprojectinput" id="deadlineproject" type="text" name="deadlineproject" placeholder="01/01/2018"><br>
  <input class="mt-2 addprojectsubmit" type="submit" value="Créer">
</form>

<?php
  if (!empty($_POST['titleproject']) AND !empty($_POST['descproject']) AND !empty($_POST['deadlineproject'])) {
    $titleproject = htmlspecialchars(addslashes(strip_tags($_POST['titleproject'])));
    $descproject = htmlspecialchars(addslashes(strip_tags($_POST['descproject'])));
    $deadlineproject = htmlspecialchars(addslashes(strip_tags($_POST['deadlineproject'])));
    if (preg_match("#[0-9]{2}+/[0-9]{2}+/[0-9]{4}$#", $deadlineproject)) {
      $addproject = $bdd->prepare("INSERT INTO projects (project_name, project_desc, project_limit, creator_name, id_account) VALUES (:name, :description, :datelimit, :creator, :idaccount)");
      $addproject->execute(array(
        'name' => $titleproject,
        'description' => $descproject,
        'datelimit' => $deadlineproject,
        'creator' => $_SESSION['pseudo'],
        'idaccount' => $_SESSION['id']
      ));
      header('location: index.php');
    } else {
      echo "<p class='colorred font-weight-bold pt-3 text-center'>Il s'emblerait que vous n'ayez pas mit une bonne date format: (01/01/2018).</p>";
    }
  }


?>

<?php require('script.php'); ?>
