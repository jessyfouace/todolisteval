<?php
session_start();
require('config.php');
// Check if user connected
if (!empty($_SESSION['id'])) {
  // Check if checkbox is checked
if (!empty($_POST['checkedorno'])) {
  // Take the id of the checkbox put him on 1 and push on bdd
  $checked = $bdd->prepare('UPDATE tasklist SET checked=1 WHERE task_name=:takename');
  $checked->execute(array(
    'takename' => $_GET['name']
  ));
  header('location: viewtask.php?list=' . $_GET['list'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '');
} else {
  // If the checkbox is no't checked, set the checkbox at 0 and push on bdd
  $notchecked = $bdd->prepare('SELECT * FROM tasklist WHERE checked=1');
  $notchecked = $notchecked->fetchAll();
  $checked = $bdd->prepare('UPDATE tasklist SET checked=0 WHERE task_name=:takename');
  $checked->execute(array(
    'takename' => $_GET['name']
  ));
  header('location: viewtask.php?list=' . $_GET['list'] . '&project=' . $_GET['project'] . '&creator=' . $_GET['creator'] . '');
}
} else {
 header('location: index.php');
}
?>
