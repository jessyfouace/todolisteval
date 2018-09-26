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
          $account = $bdd->prepare('SELECT * FROM accounts WHERE id = :idtake');
          $account->execute(array(
            'idtake' => $_SESSION['id']
          ));
          $account = $account->fetch();
          // if user is connected check the user id and check is he's connected 1 = connected 0 = disconnect or no account
          if ($account['verif_connect'] == 1) {
            echo '<a href="disconnect.php">
                <div class="pt-4 pr-2">
                <p>Se deconnecter</p>
                </div>
              </a>';
          }
          if ($account['verif_connect'] == 0) {
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
