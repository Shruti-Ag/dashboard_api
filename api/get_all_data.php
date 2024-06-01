<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');
require '../db.php';

$collection = getMongoCollection();

function getAllData($collection) {
    try {
        $allData = $collection->find()->toArray();
        if (empty($allData)) {
            echo json_encode(['success' => false, 'message' => 'No data found']);
            return;
        }
        echo json_encode(['success' => true, 'message' => 'All data', 'data' => $allData]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
    }
}

getAllData($collection);
?>
