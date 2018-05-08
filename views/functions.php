<?php
    session_start();
    if ((isset($_SESSION['loged'])) &&($_SESSION['loged']==true))
    {
        header('Location: ../index.php');
        exit();
    }
    function api($content,$apikey){
        $check= file_get_contents("https://api.guildwars2.com/v2/".$content."?access_token=".$apikey);
        $answer = json_decode($check,true);
    return $answer;}