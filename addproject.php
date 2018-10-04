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
<?php
if (!empty($_SESSION['id'])) { ?>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="index.php">Accueil</a>
  <span class="breadcrumb-item active">Ajouter un produit</span>
</nav>
<form class="text-center" action="addproject.php" method="post">
  <label for="titleproject">Titre du projet: (max 255 caractères)</label><br>
  <input class="addprojectinput" id="titleproject" type="text" name="titleproject"><br>
  <label for="descproject">Description du projet: (max 255 caractères)</label><br>
  <textarea id="descproject" name="descproject" rows="6" cols="30" placeholder="..."></textarea><br>
  <label for="deadlineproject">Date limite du projet: (format 01/01/2018)</label><br>
  <input class="addprojectinput" id="deadlineproject" type="text" name="deadlineproject" placeholder="01/01/2018"><br>
  <input class="mt-2 addprojectsubmit" type="submit" value="Créer">
</form>

<?php
// Check if input is no't empty
  if (!empty($_POST['titleproject']) AND !empty($_POST['descproject']) AND !empty($_POST['deadlineproject'])) {
    // Create date for now
    $dateday = date('Y-m-d');
    // Put the date on string version example: Thuesday 18 October 2018 but in french
    setlocale(LC_TIME, "fr_FR.iso88591");
    // Put the string on date time
    $dateformat = ucfirst(strftime("%A %d %B %G", strtotime($dateday)));
    // Protect the input by htmlspecialchars and allow guys to add simple cot
    $titleproject = htmlspecialchars(addslashes(strip_tags($_POST['titleproject'])));
    $descproject = htmlspecialchars(addslashes(strip_tags($_POST['descproject'])));
    $deadlineproject = htmlspecialchars(addslashes(strip_tags($_POST['deadlineproject'])));
    // Check if deadline is a good number 02/10/2018 for example
    if (preg_match("#[0-3]{1}[0-9]{1}+/[0-1]{1}[0-9]{1}+/[0-9]{4}$#", $deadlineproject)) {
      // Insert in to bdd all we need
      $addproject = $bdd->prepare("INSERT INTO projects (project_name, project_desc, project_limit, creator_name, id_account, create_date_string, english_date) VALUES (:name, :description, :datelimit, :creator, :idaccount, :create_date, NOW())");
      $addproject->execute(array(
        'name' => $titleproject,
        'description' => $descproject,
        'datelimit' => $deadlineproject,
        'creator' => $_SESSION['pseudo'],
        'idaccount' => $_SESSION['id'],
        'create_date' => $dateformat
      ));
      header('location: index.php');
    } else {
      echo "<p class='colorred font-weight-bold pt-3 text-center'>Il s'emblerait que vous n'ayez pas mit une bonne date format: (01/01/2018).</p>";
    }
  }
} else {
  header("location: index.php");
}
?>

<?php require('script.php'); ?>
