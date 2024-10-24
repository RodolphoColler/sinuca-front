<?php include('../services/functions.php') ?>

<?php 
    $url = "http://localhost:3000/duomatch";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Erro na decodificação JSON: " . json_last_error_msg();
        exit;
    }

    

    $matchups = CreateMatchupDuo($data);
    foreach ($matchups as $matchup) {
        echo "<div>Matchup: {$matchup->duo1} vs {$matchup->duo2}</div>";
        echo "<div><strong>{$matchup->duo1}:</strong> Vitórias: {$matchup->duo1Win} - Derrotas: {$matchup->duo1Lose}</div>";
        echo "<div><strong>{$matchup->duo2}:</strong> Vitórias: {$matchup->duo2Win} - Derrotas: {$matchup->duo2Lose}</div>";
        echo "<br>";

        echo "<div>| Winrate Duo1: " . ($matchup->duo1Win/($matchup->duo1Win+$matchup->duo1Lose))*100 . "%" . "</div><br>";
        echo "<div>| Winrate Duo2: " . ($matchup->duo2Win/($matchup->duo2Win+$matchup->duo2Lose))*100 . "%" . "</div><br>";
    }
?>