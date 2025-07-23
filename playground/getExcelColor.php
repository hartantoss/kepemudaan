<?php

    require_once('../SimpleXLSX.php');
    $xlsx = new Shuchkin\SimpleXLSX('xlsx-simple.xlsx');
    // Shuchkin\SimpleXLSX::parse($filePath)
    // Ambil nilai dari sel
    $cellValue = $xlsx->getCell(1, 'A');

    echo 'Nilai dari sel A1 adalah: ' . $cellValue;

    

?>