<?php

// # PEGAR DA API O JSON:
function jsonDecode($url)
{
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Erro na decodificação JSON: " . json_last_error_msg();
        exit;
    }

    return json_decode($response, true);
}
function getPlayer()
{
    $url = "http://localhost:3000/player";
    return jsonDecode($url);
}
function getSingleMatch()
{
    $url = "http://localhost:3000/single";
    return jsonDecode($url);
}
function getDuoMatch()
{
    $url = "http://localhost:3000/duoMatch";
    return jsonDecode($url);
}

// # ALGORITIMOS DE CRIAR PARTIDAS [SINGLE/DUO]  
function createSingleMatch()
{
    $data = getSingleMatch();

    class OnePlayer
    {
        public $name;
        public $games_played;
        public $victories;
        public $loses;
        public $win_rate;

        public function __construct($name, $games_played, $victories, $loses, $win_rate)
        {
            $this->name = $name;
            $this->games_played = $games_played;
            $this->victories = $victories;
            $this->loses = $loses;
            $this->win_rate = $win_rate;
        }
    }

    foreach ($data['singleMatch'] as $match) {
        $playerOneId = $match['player_one_id'];
        $playerTwoId = $match['player_two_id'];
        $playerOneName = $match['player_one']['name'];
        $playerTwoName = $match['player_two']['name'];
        $result = $match['result'];

        // Inicializa os jogadores se não existirem
        if (!isset($playersStats[$playerOneId])) {
            $playersStats[$playerOneId] = [
                'name' => $playerOneName,
                'games_played' => 0,
                'victories' => 0,
                'loses' => 0
            ];
        }

        if (!isset($playersStats[$playerTwoId])) {
            $playersStats[$playerTwoId] = [
                'name' => $playerTwoName,
                'games_played' => 0,
                'victories' => 0,
                'loses' => 0
            ];
        }

        // Atualiza as estatísticas
        $playersStats[$playerOneId]['games_played']++;
        $playersStats[$playerTwoId]['games_played']++;

        if ($result === $playerOneId) {
            $playersStats[$playerOneId]['victories']++;
            $playersStats[$playerTwoId]['loses']++;
        } else {
            $playersStats[$playerTwoId]['victories']++;
            $playersStats[$playerOneId]['loses']++;
        }
    }

    // Criando os objetos onePlayer
    $onePlayer = [];
    foreach ($playersStats as $stats) {
        $win_rate = $stats['games_played'] > 0 ? ($stats['victories'] / $stats['games_played']) * 100 : 0;
        $win_rate = number_format($win_rate, 2);
        $onePlayer[] = new onePlayer($stats['name'], $stats['games_played'], $stats['victories'], $stats['loses'], $win_rate);
    }

    return $onePlayer;
}

function createDuoMatch()
{
    $data = getDuoMatch();


    class Duos
    {
        public $name1;
        public $name2;
        public $games_played;
        public $victories;
        public $loses;
        public $win_rate;

        public function __construct($name1, $name2, $games_played, $victories, $loses, $win_rate)
        {
            $this->name1 = $name1;
            $this->name2 = $name2;
            $this->games_played = $games_played;
            $this->victories = $victories;
            $this->loses = $loses;
            $this->win_rate = $win_rate;
        }
    }

    foreach ($data['duoMatch'] as $duoMatch) {

        $playerOneName = $duoMatch['duo_player']['player_one']['name'];
        $playerTwoName = $duoMatch['duo_player']['player_two']['name'];
        $duoOneId = $duoMatch['duo_one_id'];

        $playerThreeName = $duoMatch['duo_player_two']['player_one']['name'];
        $playerFourName = $duoMatch['duo_player_two']['player_two']['name'];
        $duoTwoId = $duoMatch['duo_two_id'];

        $result = $duoMatch['result'];


        // Inicializa os duos se não existirem
        if (!isset($duoStats[$duoOneId])) {
            $duoStats[$duoOneId] = [
                'name1' => $playerOneName,
                'name2' => $playerTwoName,
                'games_played' => 0,
                'victories' => 0,
                'loses' => 0
            ];
        }
        if (!isset($duoStats[$duoTwoId])) {
            $duoStats[$duoTwoId] = [
                'name1' => $playerThreeName,
                'name2' => $playerFourName,
                'games_played' => 0,
                'victories' => 0,
                'loses' => 0
            ];
        }

        // Atualiza as estatísticas
        $duoStats[$duoOneId]['games_played']++;
        $duoStats[$duoTwoId]['games_played']++;

        if ($result === $duoOneId) {
            $duoStats[$duoOneId]['victories']++;
            $duoStats[$duoTwoId]['loses']++;
        } else {
            $duoStats[$duoTwoId]['victories']++;
            $duoStats[$duoOneId]['loses']++;
        }
    }

    $Duos = [];

    foreach ($duoStats as $stats) {
        //calcular winrate
        $win_rate = $stats['games_played'] > 0 ? ($stats['victories'] / $stats['games_played']) * 100 : 0;
        $win_rate = number_format($win_rate, 2);
        //objeto Duos
        $Duos[] = new Duos($stats['name1'], $stats['name2'], $stats['games_played'], $stats['victories'], $stats['loses'], $win_rate);
    }

    return $Duos;
}

// # ALGORITIMO DE EXIBIR ESTATÍSTICAS
function getWinRateGeral()
{
    $data = getPlayer();

    $onePlayer = createSingleMatch();
    $Duos = createDuoMatch();


    class PlayerGeral
    {
        public $name;
        public $games_played;
        public $victories;
        public $win_rate;

        public function __construct($name, $games_played, $victories, $win_rate)
        {
            $this->name = $name;
            $this->games_played = $games_played;
            $this->victories = $victories;
            $this->win_rate = $win_rate;
        }
    }

    $playersStats = [];

    foreach ($data['players'] as $player) {
        foreach ($onePlayer as $singleMatch) {
            if ($player['name'] == $singleMatch->name) {
                if (empty($playersStats)) {
                    $win_rate = ($singleMatch->victories / $singleMatch->games_played) * 100;
                    $win_rate = number_format($win_rate, 2);
                    $playersStats[] = new PlayerGeral(
                        $player['name'],
                        $singleMatch->games_played,
                        $singleMatch->victories,
                        $win_rate
                    );
                } else {

                    //  BUSCAR SE JA EXISTE UM OBJETO DELE

                    $busca = $player['name'];

                    $resultado = array_filter($playersStats, function ($player) use ($busca) {
                        return $player->name === $busca;
                    });

                    if (empty($resultado)) {
                        $win_rate = ($singleMatch->victories / $singleMatch->games_played) * 100;
                        $win_rate = number_format($win_rate, 2);
                        $playersStats[] = new PlayerGeral(
                            $player['name'],
                            $singleMatch->games_played,
                            $singleMatch->victories,
                            $win_rate
                        );
                    }
                }
            }
        }

        foreach ($Duos as $duoMatch) {

            if ($player['name'] == $duoMatch->name1) {
                if (empty($playersStats)) {
                    $win_rate = ($duoMatch->victories / $duoMatch->games_played) * 100;
                    $win_rate = number_format($win_rate, 2);
                    $playersStats[] = new PlayerGeral(
                        $player['name'],
                        $duoMatch->games_played,
                        $duoMatch->victories,
                        $win_rate
                    );
                } else {

                    //  BUSCAR SE JA EXISTE UM OBJETO DELE

                    $busca = $player['name'];

                    $resultado = array_filter($playersStats, function ($player) use ($busca) {
                        return $player->name === $busca;
                    });




                    if (empty($resultado)) {
                        $win_rate = ($duoMatch->victories / $duoMatch->games_played) * 100;
                        $win_rate = number_format($win_rate, 2);
                        $playersStats[] = new PlayerGeral(
                            $player['name'],
                            $duoMatch->games_played,
                            $duoMatch->victories,
                            $win_rate
                        );
                    } else {
                        $player_encontrado = reset($resultado);
                        $player_encontrado->games_played += $duoMatch->games_played;
                        $player_encontrado->victories += $duoMatch->victories;
                        $win_rate = ($player_encontrado->victories / $player_encontrado->games_played) * 100;
                        $win_rate = number_format($win_rate, 2);
                        $player_encontrado->win_rate =  $win_rate;
                    }
                }
            } else if ($player['name'] == $duoMatch->name2) {
                if (empty($playersStats)) {
                    $win_rate = ($duoMatch->victories / $duoMatch->games_played) * 100;
                    $win_rate = number_format($win_rate, 2);
                    $playersStats[] = new PlayerGeral(
                        $player['name'],
                        $duoMatch->games_played,
                        $duoMatch->victories,
                        $win_rate
                    );
                } else {

                    //  BUSCAR SE JA EXISTE UM OBJETO DELE

                    $busca = $player['name'];

                    $resultado = array_filter($playersStats, function ($player) use ($busca) {
                        return $player->name === $busca;
                    });



                    if (empty($resultado)) {
                        $win_rate = ($duoMatch->victories / $duoMatch->games_played) * 100;
                        $win_rate = number_format($win_rate, 2);
                        $playersStats[] = new PlayerGeral(
                            $player['name'],
                            $duoMatch->games_played,
                            $duoMatch->victories,
                            $win_rate
                        );
                    } else {
                        $player_encontrado = reset($resultado);
                        $player_encontrado->games_played += $duoMatch->games_played;
                        $player_encontrado->victories += $duoMatch->victories;
                        $win_rate = ($player_encontrado->victories / $player_encontrado->games_played) * 100;
                        $win_rate = number_format($win_rate, 2);
                        $player_encontrado->win_rate =  $win_rate;
                    }
                }
            }
        }
    }

    return $playersStats;
}

function SearchMatchSolo($data, $p1, $p2) {
    $matchup = [];
    foreach($data->singleMatch as $match) {
        if($match->player_one->name == $p1 && $match->player_two->name == $p2) {
            $matchup[] = $match->result;
        }
    }

    return $matchup;
}

function CreateMatchupSolo($data) {
    foreach($data->singleMatch as $match) {
        $p1 = $match->player_one->name;
        $p2 = $match->player_two->name;
        $p1Win = 0;

        $key = $p1 < $p2 ? "$p1-$p2" : "$p2-$p1";

        if (!isset($processedPairs[$key])) {
            $results = SearchMatchSolo($data, $p1, $p2);
            $p1Win = 0;

            foreach ($results as $res) {
                if ($res == $match->player_one->id) {
                    $p1Win++;
                }
            }

            $p2Win = count($results) - $p1Win;
            $p1Lose = $p2Win;
            $p2Lose = $p1Win;

            $matchups[] = new MatchupSolo(
                $p1,
                $p2,
                $p1Win,
                $p1Lose,
                $p2Win,
                $p2Lose
            );

            $processedPairs[$key] = true;
        }
    }

    return $matchups;
}

function SearchMatchDuo($data, $duo_one_id, $duo_two_id) {
    $matchup = [];
    
    foreach ($data->duoMatch as $match) {
        // Verifica se a combinação dos IDs das duplas é encontrada
        if (($match->duo_one_id == $duo_one_id && $match->duo_two_id == $duo_two_id) || 
            ($match->duo_one_id == $duo_two_id && $match->duo_two_id == $duo_one_id)) {
            $matchup[] = $match->result;
        }
    }
    
    return $matchup;
}


function CreateMatchupDuo($data) {
    $matchups = [];
    $processedPairs = [];

    foreach ($data->duoMatch as $match) {
        // IDs das duplas
        $duo_one_id = $match->duo_one_id;
        $duo_two_id = $match->duo_two_id;

        // Cria uma chave única para identificar o matchup
        $key = "$duo_one_id-$duo_two_id";

        // Verifica se o par já foi processado
        if (!isset($processedPairs[$key])) {
            // Busca os resultados das partidas entre as duplas
            $results = SearchMatchDuo($data, $duo_one_id, $duo_two_id);

            // Contagem de vitórias para cada dupla
            $duo1Wins = 0;
            foreach ($results as $result) {
                if ($result == $duo_one_id) {
                    $duo1Wins++;
                }
            }

            // Calcula vitórias e derrotas
            $totalMatches = count($results);
            $duo1Lose = $totalMatches - $duo1Wins;
            $duo2Wins = $duo1Lose;
            $duo2Lose = $duo1Wins;

            // Obtém os nomes dos jogadores para exibir no matchup
            $duo1Names = $match->duo_player->player_one->name . "-" . $match->duo_player->player_two->name;
            $duo2Names = $match->duo_player_two->player_one->name . "-" . $match->duo_player_two->player_two->name;

            // Adiciona o matchup ao array
            $matchups[] = new MatchupDuo(
                $duo1Names,
                $duo2Names,
                $duo1Wins,
                $duo1Lose,
                $duo2Wins,
                $duo2Lose
            );

            // Marca o par como processado
            $processedPairs[$key] = true;
        }
    }

    return $matchups;
}