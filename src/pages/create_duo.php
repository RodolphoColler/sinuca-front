<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script defer src="../js/create-duo.js"></script>
</head>
<body>
  <?php 
    $url = "http://localhost:3000/player";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($response);
  ?>
  <?php 
    $url = "http://localhost:3000/duo";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    $data_duo = json_decode($response);
  ?>

  <h1>Selecione dois Jogadores para formar dupla</h1>

  <form id="create-duo-form">
    <select id="select-player-one">
      <?php 
        foreach($data->players as $player) {
          echo "<option value=" .$player->id .  ">" . $player->name . "</option>";
        }
      ?>
    </select>
    <select id="select-player-two">
      <?php 
        foreach($data->players as $player) {
          echo "<option value=" .$player->id .  ">" . $player->name . "</option>";
        }
      ?>
    </select>
    <button type="submit">Criar Dupla</button>
  </form>

  <div class="players-container">
    <?php 
      foreach($data_duo->duoPlayer as $duo) {
        $player_one = $duo->player_one->name;
        $player_two = $duo->player_two->name;

        echo <<< HTML
          <p class="players-name">$player_one e $player_two</p>
        HTML;
      }
    ?>
  </div>
</body>
</html>