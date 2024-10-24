<?php include('functions.php') ?>

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

    class MatchupDuo {
        public $duo1;
        public $duo2;
        public $duo1Win;
        public $duo1Lose;
        public $duo2Win;
        public $duo2Lose;
    
        function __construct($duo1, $duo2, $duo1Win, $duo1Lose, $duo2Win, $duo2Lose) {
            $this->duo1 = $duo1;
            $this->duo2 = $duo2;
            $this->duo1Win = $duo1Win;
            $this->duo1Lose = $duo1Lose;
            $this->duo2Win = $duo2Win;
            $this->duo2Lose = $duo2Lose;
        }
    }

    $matchups = CreateMatchupDuo($data);
    foreach ($matchups as $matchup) {
        echo "<div>Matchup: {$matchup->duo1} vs {$matchup->duo2}</div>";
        echo "<div><strong>{$matchup->duo1}:</strong> Vitórias: {$matchup->duo1Win} - Derrotas: {$matchup->duo1Lose}</div>";
        echo "<div><strong>{$matchup->duo2}:</strong> Vitórias: {$matchup->duo2Win} - Derrotas: {$matchup->duo2Lose}</div>";
        echo "<br>";
    }
?>