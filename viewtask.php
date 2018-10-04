<?php session_start();
require('config.php') ?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
  <title>Valider tâche</title>
  <meta charset="utf-8">
  <meta name="description" content="Site de Todolist gratuit et automatique avec système de compte. Todolist gratuit en ligne">
<?php require('doctype.php'); ?>
<?php require('header.php'); ?>

<?php
// Check if user connected
if (!empty($_SESSION['id'])) {
  // Take all information of projects
$taskbyproject = $bdd->prepare('SELECT * FROM projects WHERE id = :getid');
$taskbyproject->execute(array(
  'getid' => $_GET['project']
));
$taskbyproject = $taskbyproject->fetch();
  // Take all information of lists
$taskbylist = $bdd->prepare('SELECT * FROM lists WHERE id = :getid');
$taskbylist->execute(array(
  'getid' => $_GET['list']
));
$taskbylist = $taskbylist->fetch();
  // show only user task
if ($taskbyproject['id_account'] == $_SESSION['id'] || $_SESSION['admin'] == "1") {
  $task = $bdd->prepare('SELECT * FROM tasks WHERE id_list = :getid');
  $task->execute(array(
    'getid' => $_GET['list']
  ));
  $task = $task->fetch();
  echo '
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="index.php">Accueil</a>
    <a class="breadcrumb-item" href="viewproject.php?project=' . $_GET['project'] . '">Voir projet</a>
    <span class="breadcrumb-item active">Voir Tâches</span>
  </nav>';
  echo "<div class='col-12 col-md-5 m-0 p-0 mt-5 mx-auto text-center nocolor mb-5'>
    <div class='titleprojectview col-12 m-0 p-0'>
      <p class='pt-2 font-weight-bold'>" . $taskbylist['list'] . "<p>
    </div>
    <div class='checkedprojectview col-12 text-center m-0 p-0'>";
    // Show all task by the id of the list
        $tasklist = $bdd->prepare('SELECT * FROM tasklist WHERE id_task = :getid');
        $tasklist->execute(array(
          'getid' => $_GET['list']
        ));
        $tasklist = $tasklist->fetchAll();
        echo "<p class='borderbottom p-3 colorred'>Après avoir cocher une case vous devez valider.</p>";
        $lengthchecked = 0;
        $lengthnotchecked = 0;
        foreach ($tasklist as $key => $value) {
          // If on bdd the task is did
          if ($value['checked'] == 1) {
            $lengthchecked++;
            echo "<form class='col-12 pb-2 pt-4' action='veriftask.php?name=" . $value['task_name'] . "&amp;list=" . $_GET['list'] . "&amp;project=" . $_GET['project'] . "&amp;creator=" . $_GET['creator'] . "' method='post'>";
            echo "<input type='checkbox' name='checkedorno' checked><p>" . $value['task_name'] . ": " .  $value['task_limit'] . "</p>
            ";
            echo "<input type='submit' value='Valider'><br>
            </form>";
            echo "<form class='col-12 pb-4 pt-2 borderbottom' action='removetask.php?idtask=" . $value['id'] . "&amp;idlist=" . $_GET['list'] . "&amp;project=" . $taskbyproject['id'] . "&amp;creator=" . $taskbyproject['id_account'] . "' method='post'>";
            echo "<input class='remove w-100 h-100' type='submit' value='&#9988;'>";
            echo "</form>";
            // If on bdd the task is no't
          } elseif ($value['checked'] == 0) {
            $lengthnotchecked++;
            echo "<form class='col-12 pb-2 pt-4' action='veriftask.php?name=" . $value['task_name'] . "&amp;list=" . $_GET['list'] . "&amp;project=" . $_GET['project'] . "&amp;creator=" . $_GET['creator'] . "' method='post'>";
              echo "<input type='checkbox' name='checkedorno'><p>" . $value['task_name'] . ": " .  $value['task_limit'] . "</p>
              ";
              echo "<input type='submit' value='Valider'><br>
              </form>";
              echo "<form class='col-12 pb-4 pt-2 borderbottom' action='removetask.php?idtask=" . $value['id'] . "&amp;idlist=" . $_GET['list'] . "&amp;project=" . $taskbyproject['id'] . "&amp;creator=" . $taskbyproject['id_account'] . "' method='post'>";
              echo "<input class='remove w-100 h-100' type='submit' value='&#9988;'>";
              echo "</form>";
          }
        }
            if ($lengthchecked > 0) {
              $calculall = $lengthchecked + $lengthnotchecked;
              $firstcalcul = $lengthchecked / $calculall;
              $secondcalcul = $firstcalcul * 100;
              
              ?><div class="col-12 m-0 p-0">
                      <div class="col-12 m-0 p-0" style="height: 50px;">
                        <div class="progress" style="height: 50px;">
                          <div id="progressbarplayer" class="informationbar colorwhite pt-3" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo floor($secondcalcul) ?>%; height: 100px;">
                            <?php echo "Fini à: "; 
                                  echo floor($secondcalcul);
                                  echo "%"; ?>
                          </div>
                        </div>
                      </div>
              </div>
            <?php }
            if($lengthchecked < 1) {
              echo "0%";
            }

  echo "<a href='addtask.php?idlist=" . $_GET['list'] . "&amp;project=" . $taskbyproject['id'] . "&amp;creator=" . $taskbyproject['id_account'] . "'><div class='addtask'>
            <i class='fas fa-plus-circle p-2'>Ajouter une tâche</i>
          </div></a>
        </div>
        </div>";
} else {
  echo "<p class='text-center pt-3 colorred font-weight-bold'>Vous n'êtes pas sur l'un de vos projet. <br> Redirection automatique.</p>";
  echo "<p class='text-center'> Si la redirection ne marche pas <a href='index.php'>Cliquez ici</a></p>";
  header('Refresh: 2; URL=index.php');
}
} else {
  header('location: index.php');
}
?>
<?php require('script.php') ?>
