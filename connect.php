<?php session_start();
require('config.php'); ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Connexion</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne. Inscription. Connexion">
<?php
require('doctype.php');
require('header.php');
?>
<?php if (empty($_SESSION['pseudo'])) { ?>
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Connection</h4>
	<p class="text-center">Toutes données restent confidentiels</p>
  <form action="connect.php" method="post">
  	<div class="form-group input-group">
          <input class="form-control" placeholder="Pseudonyme" type="text" name="connexionpseudo" required>
      </div> <!-- form-group// -->
      <div class="form-group input-group">
          <input class="form-control" placeholder="Mot de passe" type="password" name="connexionpassword" required>
      </div> <!-- form-group// -->
      <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block"> Se connecter  </button>
      </div> <!-- form-group// -->
      <p class="text-center">Pas encore inscrit ? <a href="inscription.php">S'inscrire</a> </p>
  </form>
</article>
<?php } else {
  echo "<p class='text-center pt-3 colorred font-weight-bold'>Vous êtes déjà connecter vous ne pouvez pas avoir accès à cette page. <br> Redirection automatique.</p>";
  echo "<p class='text-center'> Si la redirection ne marche pas <a href='index.php'>Cliquez ici</a></p>";
  header('Refresh: 2; URL=index.php');
  } ?>
<?php
  // if pseudo and password is no't empty
  if (!empty($_POST['connexionpseudo']) AND !empty($_POST['connexionpassword'])) {
    // Check if pseudo got good write
      if (preg_match("#[a-z0-9._-]#", $_POST['connexionpseudo'])) {
        // Check if password is good write
        if (preg_match("#[a-z0-9._-]#", $_POST['connexionpassword'])) {
          // Take all of bdd of user account
          $create = $bdd->query('SELECT * FROM accounts');
          $create = $create->fetchAll();
          // foreach of bdd for take the user name...
          foreach ($create as $key => $value) {
            // if the connect is good create session
            if ($_POST['connexionpseudo'] == $value['user_name'] AND password_verify($_POST['connexionpassword'], $value['user_password'])) {
              $_SESSION['pseudo'] = $value['user_name'];
              $_SESSION['mdp'] = password_verify($_POST['connexionpassword'], $value['user_password']);
              $_SESSION['id'] = $value['id'];
              // make the guys connected (for bdd)
              $create = $bdd->prepare('UPDATE accounts SET verif_connect=1 WHERE id=:takeid');
              $create->execute  (array(
                'takeid' => $value['id']
              ));
              echo "<p class='text-center colorgreen font-weight-bold'>Connection réussis</p>";
              header('Refresh: 1; URL=index.php');
            }
          }
        } else {
          echo "<p class='text-center colorred font-weight-bold'>Pseudo ou mot de passe faux</p>";
        }
        }
        else {
          $_SESSION['isConnect'] = 1;
          echo "<p class='text-center colorred font-weight-bold'>Pseudo ou mot de passe faux</p>";
        }
      }

require('script.php') ?>
