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