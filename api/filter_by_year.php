<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');
require '../db.php';

$collection = getMongoCollection();

function filteredByYear($collection, $year) {
    try {
        if (strlen($year) !== 4) {
            echo json_encode(['success' => false, 'message' => 'Invalid year']);
            return;
        }
        $allData = $collection->find(['end_year' => (int)$year])->toArray();
        if (empty($allData)) {
            echo json_encode(['success' => false, 'message' => 'No Data Found']);
            return;
        }
        echo json_encode(['success' => true, 'message' => "Filtered by year $year", 'data' => $allData]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
    }
}

$year = $_GET['year'];
filteredByYear($collection, $year);
?>
