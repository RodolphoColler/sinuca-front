<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="C:\wamp64\www\wordpress-6.6.2\wordpress\wp-content\themes\Tema-sem-macula/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<style>
  .player-stats {
    font-family: "Noto Sans JP", sans-serif;
    display: flex;
    align-items: center;
    background-color: whitesmoke;
    margin-bottom: 10px;
    border-radius: 30px;
    padding-left: 20px;
  }

  .player-name {
    width: 120px;
  }

  .victory {
    color: #20de6e;
    margin: 0 10px;
  }
  .lose {
    color: #de2020;
    margin: 0 10px;
  }
  .winrate-gradient {
    width: 150px;
    height: 4px;
    border-radius: 10px;
  }
</style>
<body>

<a href="../index.php">home</a>


<?php
    include_once('../services/functions.php');
    $onePlayer = createSingleMatch();
    foreach ($onePlayer as $player) {
        echo <<< HTML
          <div class="player-stats">
            <p class="player-name"> $player->name  </p>
            <p class="victory"> $player->victories V </p>
            <div class="winrate-gradient" style=" background: linear-gradient(
              to right, 
              #20de6e,
              #20de6e $player->win_rate%,
              #de2020 $player->win_rate%,
              #de2020);"
            ></div>
            <p class="lose"> $player->loses D </p>
            <p> Jogos: $player->games_played </p>
            <p> Win-rate: $player->win_rate %</p>
          </div>
        HTML;
    }
?>



</body>
</html>
