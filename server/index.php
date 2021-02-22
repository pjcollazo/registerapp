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


if (isset($_POST['total']) && isset($_POST['paid'])) {
    $data = getChange($_POST['total'], $_POST['paid']);
    echo json_encode($data);
}


?>