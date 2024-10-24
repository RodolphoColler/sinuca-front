<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script defer src="../js/createSingleMatch.js"></script>

</head>
<body>
<a href="./create_player.php">cadastrar jogador</a>
<a href="./duo_match.php">Partidas em duplas</a>
<a href="./create_duo.php">cadastrar duplas</a>
<h1>Selecione dois Jogadores para criar uma partida</h1>

<?php 
  $url = "http://localhost:3000/player";

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);

  curl_close($ch);

  $data = json_decode($response);
?>

<form id="create-single-match-form">
  <label for="">
    Vencedor:
    <select id="select-winner">
      <?php
        foreach ($data->players as $player) {
          $valor = json_encode(['id' => $player->id, 'name' => $player->name, 'rating' => $player->rating]);
          echo <<<HTML
              <option value='{$valor}'>{$player->name}</option>
          HTML;
        }
      ?>
    </select>
  </label>
  <label for="">
    Perdedor:
    <select id="select-loser">
      <?php
        foreach ($data->players as $player) {
          $valor = json_encode(['id' => $player->id, 'name' => $player->name, 'rating' => $player->rating]);
          echo <<<HTML
              <option value='{$valor}'>{$player->name}</option>
          HTML;
        }
      ?>
    </select>
  </label>
  <button type="submit">Criar Partida</button>
</form>

</body>
</html>