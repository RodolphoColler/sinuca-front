<a href="../index.php">home</a>
<?php

    /*
        //SINGLE EXIBIÇÃO:
        include_once("./single_match.php");

            //WIN-RATES
            echo '<h2  style="background: brown; color:white;">PLAYERS WIN-RATE</h2>';
            foreach ($leaderboard as $player) {
                echo <<< HTML
                        <div class="player-winrate-box" style="display:flex; gap:5px; background: black; color:white;">
                            <p>Posição: X | </p>
                            <p class="player-name"> $player->name</p>
                            <p class="player-winrate"> Win-rate: $player->win_rate %</p>
                            <p>| Rating: Y</p>
                        </div>
                        HTML;
            }


            echo '<br> <hr> <br>';


            //QTDE DE JOGOS, Vitorias e Derrotas
            echo '<h2 style="background: brown; color:white;">PLAYERS MATCHES</h2>';
            foreach ($leaderboard as $player) {
                echo <<< HTML
                        <div class="player-matches-box" style="display:flex; gap:5px; background: black; color:white;">
                            <p class="player-name"> $player->name</p>
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
                        </div>
                        HTML;
            }

        //---------------------------------------------------
        echo '<br> <hr> <br>';

        //DUO EXIBIÇÃO:
        include_once("./duo_match.php");

            //WIN-RATES
            echo '<h2 style="background: gray; color:black;">DUOS WIN-RATE</h2>';
            foreach ($Duos as $duo) {
                echo <<< HTML
                        <div class="player-winrate-box" style="display:flex; gap:5px; background: black; color:white;">
                            <p>Posição: X | </p>
                            <p class="duo-name"> $duo->name1 + </p>
                            <p class="duo-name"> $duo->name2</p>
                            <p class="duo-winrate"> Win-rate: $duo->win_rate %</p>
                            <p>| Rating: Y</p>
                        </div>
                        HTML;
            }


            echo '<br> <hr> <br>';


            //QTDE DE JOGOS, Vitorias e Derrotas
            echo '<h2 style="background: gray; color:black;">DUOS MATCHES</h2>';
            foreach ($Duos as $duo) {
                echo <<< HTML
                        <div class="player-winrate-box" style="display:flex; gap:5px; background: black; color:white;">
                            <p class="player-name"> $duo->name1</p>
                            <p class="player-name"> $duo->name2</p>
                            <p class="victory"> $duo->victories V </p>

                            <div class="winrate-gradient" style=" background: linear-gradient(
                                to right, 
                                #20de6e,
                                #20de6e $duo->win_rate%,
                                #de2020 $duo->win_rate%,
                                #de2020);"
                            ></div>
                            
                            <p class="lose"> $duo->loses D </p>
                            <p> Jogos: $duo->games_played </p>
                        </div>
                        HTML;
            }





        var_dump($leaderboard);
        echo ' <hr>  ';

        var_dump($Duos);
        echo '<br> <hr> <br>';

        // foreach($leaderboard as $player){
        //     foreach($Duos as $duo){
        //         if($duo->name1 == $player->name || $duo->name2 == $player->name ){
        //             echo "Nome: $player->name" . "<br>";
        //         } 
        //     }
        // }
    */

    include_once('../services/functions.php');
    
    $playersStats =getWinRateGeral(); 
    var_dump($playersStats);
?>