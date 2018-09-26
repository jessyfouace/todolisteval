<?php session_start(); ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Inscription</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne. Inscription. Connexion">
<?php
require('config.php');
require('doctype.php');
require('header.php');
?>
<!-- template take at https://bootsnipp.com/snippets/z8699  -->
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Inscription</h4>
	<p class="text-center">Toutes données restent confidentiels</p>
  <form action="inscription.php" method="post">
  	<div class="form-group input-group">
  		<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
  		 </div>
          <input class="form-control" placeholder="Pseudonyme" type="text" name="inscriptionpseudo" required>
      </div> <!-- form-group// -->
      <div class="form-group input-group">
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
  		 </div>
          <input class="form-control" placeholder="Adresse Email" type="email" name="inscriptionmail" required>
      </div> <!-- form-group// -->
      <div class="form-group input-group">
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
  		</div>
          <input class="form-control" placeholder="Mot de passe" type="password" name="firstpasswordinscription" required>
      </div> <!-- form-group// -->
      <div class="form-group input-group">
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
  		</div>
          <input class="form-control" placeholder="Répetez le mot de passe" type="password" name="secondpasswordinscription" required>
      </div> <!-- form-group// -->
      <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block"> Créer le compte  </button>
      </div> <!-- form-group// -->
      <p class="text-center">Déjà inscrit ? <a href="connect.php">Se Connecter</a> </p>
  </form>
</article>
<?php require('config.php') ?>
<?php // Check if the pseudo password and mail is no't empty
  if (!empty($_POST['inscriptionpseudo']) AND !empty($_POST['firstpasswordinscription']) AND !empty($_POST['secondpasswordinscription']) AND !empty($_POST['inscriptionmail'])) {
    // see if first password is same as second
    if ($_POST['firstpasswordinscription'] == $_POST['secondpasswordinscription']) {
      // Security for mail
      if (preg_match("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['inscriptionmail'])) {
        // Verify mail is no't used
        $checkmail = $bdd->prepare('SELECT * FROM accounts WHERE user_mail=:checkmail');
        $checkmail->execute(array(
          'checkmail' => $_POST['inscriptionmail']
        ));
        $checkmail = $checkmail->fetchAll();
        if ($checkmail) {
          echo "<p class='text-center colorred'>Adresse e-mail déjà utiliser</p>";
          header('location=inscription.php');
        } else {
        // Security for pseudo
        if (preg_match("#[a-z0-9._-]#", $_POST['inscriptionpseudo'])) {
          // Check if the pseudo is no't utilised
          $checkpseudo = $bdd->prepare('SELECT * FROM accounts WHERE user_name=:checkpseudo');
          $checkpseudo->execute(array(
            'checkpseudo' => $_POST['inscriptionpseudo']
          ));
          $checkpseudo = $checkpseudo->fetchAll();
          if ($checkpseudo) {
            echo "<p class='text-center colorred'>Pseudo déjà utiliser</p>";
            header('location=inscription.php');
          } else {
            // Security for password
            if (preg_match("#[a-z0-9._-]#", $_POST['firstpasswordinscription'])) {
              // if all security passed, push the information of the user in bdd for create account
              $create = $bdd->prepare("INSERT INTO accounts (user_name, user_mail, user_password, verif_connect) VALUES (:name, :mail, :password, :connect)");
              $create->execute(array(
                'name' => $_POST['inscriptionpseudo'],
                'mail' => $_POST['inscriptionmail'],
                'password' => password_hash($_POST['firstpasswordinscription'], PASSWORD_DEFAULT),
                'connect' => 0
              ));
              // take the id of the user
              $lastid = $bdd->lastInsertId();
              // select the user by the id for create session of him
                $create = $bdd->query('SELECT * FROM accounts WHERE id=' . $lastid . '');
                $create = $create->fetchAll();
                foreach ($create as $key => $value) {
                  $_SESSION['pseudo'] = $value['user_name'];
                  $_SESSION['mdp'] = password_verify($_POST['firstpasswordinscription'], $value['user_password']);
                  $_SESSION['id'] = $value['id'];
                }
              echo "<br><p class='text-center colorgreen'>Inscription Réussis.</p>";
              header('Refresh: 2; URL=connect.php');
            }
            else {
              $_SESSION['isConnect'] = 0;
              echo "<p class='text-center colorred'>Entrez un bon mot de passe</p>";
            }
          }
        } else {
            $_SESSION['isConnect'] = 0;
            echo "<p class='text-center colorred'>Le pseudo est soit déjà utiliser ou non valide</p>";
        }
      }
      } else {
        $_SESSION['isConnect'] = 0;
        echo "<p class='text-center colorred'>Entrez une bonne adresse e-mail</p>";
      }
    }
    else {
      echo "<p class='text-center colorred'>Les 2 mot de passe ne sont pas identique</p>";
    }
  }
?>
<?php require('script.php') ?>
