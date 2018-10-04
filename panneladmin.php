<?php session_start();
require('config.php');
// Verify if person is connected
if(!empty($_SESSION['id'])){
// Verify if person is an admin 
if($_SESSION['admin'] == 1) {?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Pannel administrateur</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php'); ?>
<?php require('header.php'); ?>
<nav class="breadcrumb mb-0">
  <a class="breadcrumb-item" href="index.php">Accueil</a>
  <span class="breadcrumb-item active">Pannel Administrateur</span>
</nav>



<!-- Nav for admin, can see organigram members and project deleted, only fondateur can add and remove admin -->
<div class="col-12 m-0 p-0 w-100" style="background-color: #f9f9fa;">
  <ul class="col-12 text-center m-0 p-0 list-inline">
    <li class="col-12 col-md-3 m-0 p-0 list-inline-item text-center">
      <p class="pt-3 pb-3 m-0"><a class="pt-3 pb-3" href="panneladmin.php?basic=1">Organigramme</a></p>
    </li>
    <li class="col-12 col-md-3 m-0 p-0 list-inline-item text-center">
      <p class="pt-3 pb-3 m-0"><a class="pt-3 pb-3" href="panneladmin.php?basic=2">Membres</a></p>
    </li>
    <li class="col-12 col-md-3 m-0 p-0 list-inline-item text-center">
      <p class="pt-3 pb-3 m-0"><a class="pt-3 pb-3" href="panneladmin.php?basic=3">Projet Supprimer</a></p>
    </li>
    <?php if ($_SESSION['pseudo'] == "Rayteur") {?>
    <li class="col-12 col-md-2 m-0 p-0 list-inline-item text-center">
      <p class="pt-3 pb-3 m-0"><a class="pt-3 pb-3" href="panneladmin.php?basic=4">Add/Remove Admin</a></p>
    </li>
    <?php } ?>
  </ul>
</div>






<?php 
// Part of organigram
if ($_GET['basic'] == 1) {?>
<div class="col-12 col-md-11 mt-3">
<div class="row m-0 p-0">
  <div class="col-12 col-md-4 mx-auto text-center m-0 p-0 mb-3 colorwhite" style="background-color: #1aaf5d; border-radius: 10px;">
            <i class="fas fa-plus fa-1x pt-3"></i>
            <i class="fas fa-user fa-2x pt-3"></i>
      <?php
      // See how many acconts is created
      $countuser = $bdd->query('SELECT * FROM accounts');
            $countuser = $countuser->fetchAll();
            $countuseraccount = 0;
            foreach ($countuser as $key => $value) {
              $countuseraccount++;
            } 
            echo "<p class='m-0 p-0' style='font-size: 30px;'>$countuseraccount</p>";
      ?>
      <p style='font-size: 25px;'>Compte(s) créer</p>
  </div>

  <div class="col-12 col-md-4 mx-auto text-center m-0 p-0 mb-3 colorwhite" style="background-color: #1aaf5d; border-radius: 10px;">
      <i class="fas fa-users fa-2x pt-3"></i>
      <?php
      // See how many people is connected actually
      $countuserconnect = $bdd->query('SELECT * FROM accounts WHERE verif_connect = 1');
            $countuserconnect = $countuserconnect->fetchAll();
            $countuseraccountconnect = 0;
            foreach ($countuserconnect as $key => $value) {
              $countuseraccountconnect++;
            } 
            echo "<p class='m-0 p-0' style='font-size: 30px;'>$countuseraccountconnect</p>";
      ?>
      <p style='font-size: 25px;'>Personne(s) connectées</p>
  </div>
</div>

<div class="row colorwhite m-0 p-0">
  <div class="col-12 col-md-3 mx-auto text-center mb-3" style="background-color: #2c97df; border-radius: 10px;">
    <i class="fas fa-project-diagram fa-2x pt-3"></i><br>
    <?php 
    // Count how many project is create
    $countproject = $bdd->query('SELECT * FROM projects');
          $countproject = $countproject->fetchAll();
          $count = 0;
          foreach ($countproject as $key => $value) {
            $count++;
          } 
          echo "<p class='m-0 p-0' style='font-size: 30px;'>$count</p>";
    ?>
    <p style='font-size: 25px;'>Projet(s) créer</p>
  </div>

  <div class="col-12 col-md-3 mx-auto text-center mb-3" style="background-color: #ea4b35; border-radius: 10px;">
    <i class="fas fa-list-ul fa-2x pt-3"></i>
    <?php 
    // Count how many list is create
    $countlist = $bdd->query('SELECT * FROM lists');
          $countlist = $countlist->fetchAll();
          $countlists = 0;
          foreach ($countlist as $key => $value) {
            $countlists++;
          } 
          echo "<p class='m-0 p-0' style='font-size: 30px;'>$countlists</p>";
    ?>
    <p style='font-size: 25px;'>Liste(s) créer</p>
  </div>

  <div class="col-12 col-md-3 mx-auto text-center mb-3" style="background-color: #f59c00; border-radius: 10px;">
    <i class="fas fa-thumbtack fa-2x pt-3"></i><br>
    <?php 
    // Count how many task is create
    $counttask = $bdd->query('SELECT * FROM tasklist');
          // See all tables (for if guys got more than 1 project)
          $counttask = $counttask->fetchAll();
          // foreach for put all personal project
          $counttasks = 0;
          foreach ($counttask as $key => $value) {
            $counttasks++;
          } 
          echo "<p class='m-0 p-0' style='font-size: 30px;'>$counttasks</p>";
    ?>
    <p style='font-size: 25px;'>Tâche(s) créer</p>
  </div>
</div>

<?php }








// Part of members list
if ($_GET['basic'] == 2) {?>
      <?php $countuser = $bdd->query('SELECT * FROM accounts');
            $countuser = $countuser->fetchAll();
            $countuseraccount = 0;
            // Simple table for see what's all collumn
            echo "<ul class='mt-3 col-12 col-md-11 mx-auto list-inline'>
                      <li class='p-3 col-12 col-md-5 list-inline-item'>
                        <p class='m-0 p-0'>Pseudonyme:</p>
                      </li>
                      <li class='p-3 col-12 col-md-5 list-inline-item'>
                        <p class='m-0 p-0'>Adresse E-mail:</p>
                      </li>
                      <li class='p-3 col-12 col-md-1 list-inline-item'>
                        <p class='m-0 p-0'>Bannir:</p>
                      </li>
                    </ul>
                    ";
            foreach ($countuser as $key => $value) {
            // Don't see admin
              if ($value['admin'] == 1) {
                echo "";
              } else {
            // Can see user name / Mail / and ban him, that's why can't see admin
              echo "<ul class='mt-3 col-12 col-md-11 mx-auto list-inline' style='border: 1px solid black;'>
                      <li class='p-3 col-12 col-md-5 list-inline-item'>
                        <p class='m-0 p-0'>" . $value['user_name'] . "</p>
                      </li>
                      <li class='p-3 col-12 col-md-5 list-inline-item'>
                        <p class='m-0 p-0'>" . $value['user_mail'] . "</p>
                      </li>
                      <li class='p-3 col-12 col-md-1 list-inline-item'>
                        <p class='m-0 p-0'><a class='btn btn-danger' href='panneladmin.php?basic=666&id=" . $value['id'] . "' style='font-weight: normal;'>Bannir</a></p>
                      </li>
                    </ul>
                    ";
              }
            } 
       }

// Verification for ban
if ($_GET['basic'] == 666) {
  $verifuser = $bdd->query('SELECT * FROM accounts');
  $verifuser = $verifuser->fetchAll();
  foreach ($verifuser as $key => $value) {
    // Verify if user exist
    if ($_GET['id'] == $value['id']) {
        // Verify for security if admin won't ban another admin
        $verifadmin = $bdd->prepare('SELECT * FROM accounts WHERE admin = 1 AND id =' . $_GET["id"] . '');
        $verifadmin->execute();
        $verifadmin = $verifadmin->fetch();
        if ($_GET['id'] == $verifadmin['id']) {
          header('location: panneladmin.php?basic=2');
        } else {
          // Ban user
          $banuser = $bdd->exec("DELETE FROM accounts WHERE id =" . $_GET['id'] . "");
          header('location: panneladmin.php?basic=2');
        }
    }
  }
}







// Part for see all projects have been removed
if ($_GET['basic'] == 3) {
  echo "En cours de création.";
}







// Part only for fondator (Rayteur) for add or remove admin
if ($_GET['basic'] == 4 AND $_SESSION['id'] == 24) {
      echo '<form class="col-12 text-center" action="panneladmin.php?basic=4" method="post">
        <label for="addadmin">Pseudo de la personne à ajouter en tant qu\'administrateur:</label><br>
        <input id="addadmin" type="text" name="nickname">
        <input type="submit" value="Valider">
      </form>';
      echo '<form class="col-12 text-center pt-5" action="removeadmin.php?sendid=' . $_SESSION["id"] . '" method="post">
        <label for="removeadmin">Pseudo de l\'administrateur à supprimer:</label><br>
        <input id="removeadmin" type="text" name="nicknameadmin">
        <input type="submit" value="Valider">
      </form>';


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
      header('Refresh: 1.5; URL=panneladmin.php?basic=4');
    }  else {
        echo '<p class="colorred font-weight-bold text-center pt-2">Cet Administrateur n\'existe pas.</p>';
        header('Refresh: 1.5; URL=panneladmin.php?basic=4'); 
      }
  }
}





} else {
            header('location: index.php'); 
        }
} else {
    header('location: index.php');
}?>