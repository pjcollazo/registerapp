<?php

function getChange(float $total, float $paid) {

    $denominations = [
        100 => 0,
        50 => 0,
        20 => 0,
        10 => 0,
        5 => 0,
        1 => 0,
        "0.5"=> 0,
        "0.25" => 0,
        "0.1" => 0,
        "0.05" => 0,
        "0.01" => 0,
    ];

    $tender = $paid - $total;

    if ($tender < 0) {
        return $tender;
    }

    foreach(array_keys($denominations) as $denom) {
        $denom = floatval($denom);
        $tender = round($tender, 2);
        while ($tender > 0 && floor($tender / $denom)) {
            $bills = floor($tender / $denom);
            $denominations[(string) $denom] += $bills;
            $tender -= ($bills * $denom);
        }
    }

    return $denominations;
}


if (isset($_GET['total']) && isset($_GET['paid'])) {
    //set reponse headers
    header('Content-type: application/json');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Origin: *'); 
    //
    $data = getChange($_GET['total'], $_GET['paid']);
    echo json_encode($data);
}


?>