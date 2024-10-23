<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

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
</head>

<body> 
<a href="../index.php">home</a>

  <?php
  
      include_once('../services/functions.php');
      $Duos = createDuoMatch();

      foreach ($Duos as $duo) {
        echo <<< HTML
          <div class="player-stats">
            <p class="player-name"> $duo->name1 </p>
            <p class="player-name"> $duo->name2 </p>
            <p class="victory"> $duo->victories V </p>
            <div class="winrate-gradient" style=" background: linear-gradient(
              to right, 
              #20de6e,
              #20de6e $duo->win_rate%,
              #de2020 $duo->win_rate%,
              #de2020);"
            ></div>
            <p class="lose"> $duo->loses D </p>
            <p> Jogos: $duo->games_played |</p>
            <p> | Win-rate: $duo->win_rate %</p>
          </div>
        HTML;
      }
      

  ?>

</body>

</html>