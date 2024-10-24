<?php include('../services/functions.php') ?>

<?php 
    $url = "http://localhost:3000/single";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Erro na decodificação JSON: " . json_last_error_msg();
        exit;
    }

    

    $matchups = CreateMatchupSolo($data);
    foreach ($matchups as $matchup) {
        echo "<div>Matchup: {$matchup->player1} vs {$matchup->player2}</div>";
        echo "<div><strong>{$matchup->player1}:</strong> Vitórias: {$matchup->p1Win} - Derrotas: {$matchup->p1Lose}</div>";
        echo "<div><strong>{$matchup->player2}:</strong> Vitórias: {$matchup->p2Win} - Derrotas: {$matchup->p2Lose}</div>";
        echo "<br>";

        echo "<div>| Winrate P1: " . ($matchup->p1Win/($matchup->p1Win+$matchup->p1Lose))*100 . "%" . "</div><br>";
        echo "<div>| Winrate P2: " . ($matchup->p2Win/($matchup->p2Win+$matchup->p2Lose))*100 . "%" . "</div><br>";
    }

    
?>