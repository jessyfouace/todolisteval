<?php session_start();
require('config.php') ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Accueil</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php'); ?>
<?php require('header.php'); ?>
<?php
  if (!empty($_SESSION['id'])) {
    // check if the id of the session (by connect) is on the bdd
    $create = $bdd->prepare('SELECT * FROM accounts WHERE id = :idtake');
    $create->execute(array(
      'idtake' => $_SESSION['id']
    ));
    $create = $create->fetch();
    // if user is connected check the user id and check is he's connected
    if ($create['verif_connect'] == 1) {
      echo '<div class="container mx-auto p-0 m-0 pt-2 col-12 text-center">
        <a href=""><p class="col-6 mx-auto bgcircle backgroundgrey textaddproject">+</p></a>
      </div>
      <p class="text-center pb-2">Ajouter un projet</p>';
    } else {
      echo '<p class="text-center pt-3">Pour ajouter un projet vous devez vous <a href="connect.php">Connecter</a></p>';
    }
  } else {
    echo '<p class="text-center pt-3">Pour ajouter un projet vous devez vous <a href="connect.php">Connecter</a></p>';
  }
?>
  <div class="col-md-8 mx-auto mt-4" class="container">
    <div class="row col-12 m-0 p-0">
      <a class="p-0 m-0 col-3 col-md-1" href="">
        <i class="fas fa-trash-alt col-12 text-center p-0 m-0 pt-3 pb-2 pb-md-0"></i>
      </a>
      <a class="borderindex col-12 col-md-10 p-0 m-0 backgroundgrey" href="viewproject.php">
        <div class="row justify-content-between m-0 p-0 col-12">
          <div class="nocolor col-8">
            <p class="pt-2">NOM DU PROJET</p>
          </div>
          <i class="pt-3 borderindex seemore fas fa-arrow-right pl-1 pr-1"> Voir plus</i>
        </div>
      </a>
    </div>
  </div>
<?php require('script.php'); ?>
