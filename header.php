<header>
  <div class="row justify-content-between m-0 p-0">
    <a href="index.php">
      <div>
        <img class="sizeimage pl-3 pt-1 pb-2" src="img/logo.png" alt="Logo de mon site de todolist">
      </div>
    </a>

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
            echo '<a href="disconnect.php">
                <div class="pt-4 pr-2">
                <p>Se deconnecter</p>
                </div>
              </a>';
          }
          if ($create['verif_connect'] == 0) {
            echo '<a href="connect.php">
                <div class="pt-4 pr-2">
                <p>Se connecter</p>
                </div>
              </a>';
          }
        } else {
            echo '<a href="connect.php">
                <div class="pt-4 pr-2">
                <p>Se connecter</p>
                </div>
              </a>';
          }
        ?>

  </div>
</header>
