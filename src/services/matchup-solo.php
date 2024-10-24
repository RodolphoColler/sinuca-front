<?php include('functions.php') ?>

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

    class MatchupSolo {
        public $player1;
        public $player2;
        public $p1Win;
        public $p1Lose;
        public $p2Win;
        public $p2Lose;
    
        function __construct($player1, $player2, $p1Win, $p1Lose, $p2Win, $p2Lose)
        {
            $this->player1 = $player1;
            $this->player2 = $player2;
            $this->p1Win = $p1Win;
            $this->p1Lose = $p1Lose;
            $this->p2Win = $p2Win;
            $this->p2Lose = $p2Lose;
        }
    }

    $matchups = CreateMatchupSolo($data);
    foreach ($matchups as $matchup) {
        echo "<div>Matchup: {$matchup->player1} vs {$matchup->player2}</div>";
        echo "<div><strong>{$matchup->player1}:</strong> Vitórias: {$matchup->p1Win} - Derrotas: {$matchup->p1Lose}</div>";
        echo "<div><strong>{$matchup->player2}:</strong> Vitórias: {$matchup->p2Win} - Derrotas: {$matchup->p2Lose}</div>";
        echo "<br>";
    }
?>