<?php session_start();
require('config.php') ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Détail Projet</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php');
require('header.php');

// Verify if user is connected
if (!empty($_SESSION['pseudo'])) {
  $account = $bdd->prepare('SELECT * FROM accounts WHERE id = :idtake');
  $account->execute(array(
    'idtake' => $_SESSION['id']
  ));
  $account = $account->fetch();
  // if user is connected check the user id and check is he's connected
  if ($account['verif_connect'] == 1) {
    // If the person who check the project is no't an admin
    if ($_SESSION['id'] !== "16") {
      $detailproject = $bdd->prepare('SELECT * FROM projects WHERE id_account = :idtake AND id = :getid');
      $detailproject->execute(array(
        'idtake' => $_SESSION['id'],
        'getid' => $_GET['project']
      ));
      $detailproject = $detailproject->fetch();
    } else {
      // if it's an admin
      $detailproject = $bdd->prepare('SELECT * FROM projects WHERE id = :getid');
      $detailproject->execute(array(
        'getid' => $_GET['project']
      ));
      $detailproject = $detailproject->fetch();
    }
    // Security for user can't see other project without admin can see all project
    if ($detailproject['id_account'] == $_SESSION['id'] || $_SESSION['id'] == "16") {
      echo "<p class='text-center pt-2'>Nom du projet: " . $detailproject['project_name'] . "</p>
            <p class='text-center'>Description du projet: " . $detailproject['project_desc'] . "</p>
            <p class='text-center'>Date limite du projet: " . $detailproject['project_limit'] . "</p>";
      // Check tasks table
      $listproject = $bdd->prepare('SELECT * FROM lists WHERE id_project = :getid');
      $listproject->execute(array(
        'getid' => $_GET['project']
      ));
      $listproject = $listproject->fetchAll();
      echo "<div class='row col-12 col-md-9 mx-auto m-0 p-0'>";
      foreach ($listproject as $key => $value) {
        echo "<a class='col-12 col-md-5 mt-5 m-0 p-0 mx-auto' href='viewtask.php?list=" . $value['id'] . "&amp;project=" . $_GET['project'] . "&amp;creator=" . $value['id_creator'] . "'><div class='col-12 m-0 p-0 mx-auto text-center nocolor'>
          <div class='titleprojectview col-12 m-0 p-0'>
          <form class='pt-1 position-absolute' action='removelist.php?list=" . $value['id'] . "&amp;project=" . $_GET['project'] . "' method='post'>
            <input class='remove w-100 h-100' type='submit' value='&#9988;'>
          </form>
            <p class='pt-2'>" . $value['list'] . "<p>
          </div>
          <div class='checkedprojectview'>
            <ul class='m-0 p-0'>";
            $tasklist = $bdd->prepare('SELECT * FROM tasklist WHERE id_task = :idlist');
            $tasklist->execute(array(
              'idlist' => $value['id']
            ));
            $tasklist = $tasklist->fetchAll();
            foreach ($tasklist as $key => $value) {
              if ($value['checked'] == 1) {
                echo "<li>&#10003;" . $value['task_name'] . ": " . $value['task_limit'] .  "</li>";
              } elseif ($value['checked'] == 0) {
                echo "<li>" . $value['task_name'] . ": " . $value['task_limit'] . "</li>";
              }
            }
            echo "</ul>
          </div>
        </div></a>";
      }
      echo "</div>";
      echo "<form class='text-center pt-5' action='veriflist.php?project=" . $_GET['project'] ."' method='post'>
        <p>Créer un tableau de tâche</p>
        <label for='tasktablname'>Nom du tableau de tâche: (max 20 caractères)</label><br>
        <input id='tasktablname' type='text' name='list_name'><br>
        <input class='mt-2' type='submit' value='Envoyer'>
      </form>";
    } else {
      // if user is no't on he's project
      echo "<p class='text-center pt-3 colorred font-weight-bold'>Vous n'êtes pas sur l'un de vos projet. <br> Redirection automatique.</p>";
      echo "<p class='text-center'> Si la redirection ne marche pas <a href='index.php'>Cliquez ici</a></p>";
      header('Refresh: 2; URL=index.php');
    }
  }
} else {
  echo '<p class="text-center pt-3">Pour voir votre projet vous devez vous <a href="connect.php">Connecter</a></p>';
}

require('script.php'); ?>
