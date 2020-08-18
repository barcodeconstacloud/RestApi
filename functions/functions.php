<?php

function array2csv($fields, $delimiter = ",", $enclosure = '"') {
    $buffer = fopen('php://temp', 'r+');
    fputcsv($buffer, $fields, $delimiter, $enclosure);
    rewind($buffer);
    $csv = fgets($buffer);
    fclose($buffer);
    return $csv;
}

