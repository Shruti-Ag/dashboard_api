<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');
require 'db.php';

$collection = getMongoCollection();

function sanitizeData($data) {
    array_walk_recursive($data, function (&$value) {
        if (is_string($value)) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            if (!mb_check_encoding($value, 'UTF-8')) {
                $value = utf8_encode($value);
            }
        }
    });
    return $data;
}

function insertCSVDataIntoMongoDB($filePath, $collection) {
    if (($handle = fopen($filePath, 'r')) !== false) {
        $header = fgetcsv($handle); 
        echo json_encode($header);

        while (($row = fgetcsv($handle)) !== false) {
            $data = [
                "end_year" => (int)$row[0], 
                "citylng" => (float)$row[1],
                "citylat" => (float)$row[2],
                "intensity" => (int)$row[3],
                "sector" => $row[4],
                "topic" => $row[5],
                "insight" => $row[6],
                "swot" => $row[7],
                "url" => $row[8],
                "region" => $row[9],
                "start_year" => (int)$row[10],
                "impact" => $row[11],
                "added" => $row[12],
                "published" => $row[13],
                "city" => $row[14],
                "country" => $row[15],
                "relevance" => (int)$row[16],
                "pestle" => $row[17],
                "source" => $row[18],
                "title" => $row[19],
                "likelihood" => (int)$row[20]
            ];
            print_r($data);
            $data = sanitizeData($data);
            $collection->insertOne($data);
        }

        fclose($handle);
    }
}
$csvFilePath = 'Data.csv';

// Insert data into MongoDB if not already inserted
// insertCSVDataIntoMongoDB($csvFilePath, $collection);
?>