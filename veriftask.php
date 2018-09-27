<?php
require('config.php');
if (!empty($_POST['checkedorno'])) {
  $checked = $bdd->prepare('UPDATE tasklist SET checked=1 WHERE task_name=:takename');
  $checked->execute(array(
    'takename' => $_GET['name']
  ));
  header('location: viewtask.php?list=' . $_GET['list'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '');
} else {
  $notchecked = $bdd->prepare('SELECT * FROM tasklist WHERE checked=1');
  $notchecked = $notchecked->fetchAll();
  $checked = $bdd->prepare('UPDATE tasklist SET checked=0 WHERE task_name=:takename');
  $checked->execute(array(
    'takename' => $_GET['name']
  ));
  header('location: viewtask.php?list=' . $_GET['list'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '');
}
?>
