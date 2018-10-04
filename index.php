<?php session_start();
require('config.php');
// Auto remove project abouth 5 months
// check if anyone is connected for auto remove projects
if (!empty($_SESSION['pseudo'])) {
  // Connect bdd projects
    $checkdate = $bdd->query('SELECT * FROM projects');
    $checkdate = $checkdate->fetchAll();
    foreach ($checkdate as $key => $value) {
      // Take the date of all projects and transform string to date
      $dt = new DateTime($value['english_date']);
      // Set format english
      $dt->format('Y-m-d');
      // Add 5 months to projects
      $dt->modify('+5 months');
      // Take the actual date
      $dtnow = new DateTime(date('Y-m-d'));
      // Set format (security) on english
      $dtnow->format('Y-m-d');
      // Take the difference of last date and actual date
      $interval = $dtnow->diff($dt);
      if ($dtnow >= $dt) {
        // Remove project where id = value id
        $removeproject = $bdd->exec("DELETE FROM projects WHERE id =" . $value['id'] . "");
      }
    }
}
 ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Accueil TodoList</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php'); ?>
<?php require('header.php'); ?>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="index.php">Accueil</a>
</nav>
<?php
  if (!empty($_SESSION['pseudo'])) {
    if ($_SESSION['admin'] == 1) {
      echo "<a href='addadmin.php'><div class='pt-2 pb-0 col-12 text-center admin'>
      <p>Ajouter un administrateur</p>
      </div></a>";
    }
    // check if the id of the session (by connect) is on the bdd
    $account = $bdd->prepare('SELECT * FROM accounts WHERE id = :idtake');
    $account->execute(array(
      'idtake' => $_SESSION['id']
    ));
    $account = $account->fetch();
    // if user is connected check the user id and check is he's connected
    if ($account['verif_connect'] == 1) {
      echo '<p class="colorred text-center pt-2 font-weight-bold">Vos projets seront automatiquement supprimer au bout de 5 mois.</p>';
      echo '<div class="container mx-auto p-0 m-0 pt-2 col-12 text-center">
        <a href="addproject.php"><p class="mx-auto bgcircle backgroundgreycircle textaddproject">+</p></a>
      </div>
      <p class="text-center pb-2">Ajouter un projet</p>';
      // Watch the personal project with the id
      if ($_SESSION['admin'] !== "1") {
        $checkproject = $bdd->prepare('SELECT * FROM projects WHERE id_account = :idtake ORDER BY id DESC');
        $checkproject->execute(array(
          'idtake' => $_SESSION['id']
        ));
        // See all tables (for if guys got more than 1 project)
        $checkproject = $checkproject->fetchAll();
        // foreach for put all personal project
        foreach ($checkproject as $key => $value) {
          echo '<div class="col-md-8 mx-auto mt-4 container">
            <div class="row col-12 m-0 p-0">
                <form class="p-0 m-0 col-3 col-md-1" action="removeproject.php?project=' . $value['id'] . '" method="post">
                  <input class="remove w-100 h-100" type="submit" value="&#9988;">
                </form>
              <a class="borderindex col-12 col-md-10 p-0 m-0 backgroundgrey" href="viewproject.php?project=' . $value['id'] . '">
                <div class="row justify-content-between m-0 p-0 col-12">
                  <div class="nocolor col-8">
                    <p class="pt-2">' . $value['project_name'] . '</p>
                  </div>
                  <i class="pt-3 borderindex seemore fas fa-arrow-right pl-1 pr-1"> Voir plus</i>
                </div>
              </a>
            </div>
          </div>';
        }
      } else {
        $admincheck = $bdd->query('SELECT * FROM projects ORDER BY creator_name');
        // See all tables (for if guys got more than 1 project)
        $admincheck = $admincheck->fetchAll();
        // foreach for put all personal project
        foreach ($admincheck as $key => $value) {
          echo '<div class="col-md-8 mx-auto mt-4">
            <div class="row col-12 m-0 p-0">
                <form class="p-0 m-0 col-3 col-md-1" action="removeproject.php?project=' . $value['id'] . '" method="post">
                  <input class="remove w-100 h-100" type="submit" value="&#9988;">
                </form>
              <a class="borderindex col-12 col-md-10 p-0 m-0 backgroundgrey" href="viewproject.php?project=' . $value['id'] . '">
                <div class="row justify-content-between m-0 p-0 col-12">
                  <div class="nocolor col-8">
                    <p class="pt-2">' . $value['project_name'] . ' | Créer par: ' . $value['creator_name'] . ' le ' . $value['create_date_string'] .'</p>
                  </div>
                  <i class="pt-3 borderindex seemore fas fa-arrow-right pl-1 pr-1"> Voir plus</i>
                </div>
              </a>
            </div>
          </div>';
      }
    }
  } else {
      header('location: disconnect.php');
    }
  } else {
    header('location: connect.php');
  }
?>

<?php require('script.php'); ?>
