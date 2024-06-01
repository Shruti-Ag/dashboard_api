<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');
require '../db.php';

$collection = getMongoCollection();

function filteredByAny($collection, $search)
{
    try {
        if (strlen($search) < 3) {
            echo json_encode(['success' => false, 'message' => 'Invalid search']);
            return;
        }
        $allData = $collection->find([
            '$or' => [
                ['region' => [ '$regex' => $search, '$options' => 'i' ]],
                ['sector' => ['$regex' => $search, '$options' => 'i']],
                ['topic' => ['$regex' => $search, '$options' => 'i']],
                ['pestle' => ['$regex' => $search, '$options' => 'i']],
                ['insight' => ['$regex' => $search, '$options' => 'i']],
                ['source' => ['$regex' => $search, '$options' => 'i']],
                ['country' => ['$regex' => $search, '$options' => 'i']],
                ['city' => ['$regex' => $search, '$options' => 'i']],
                ['swot' => ['$regex' => $search, '$options' => 'i']],

                ['title' => ['$regex' => $search, '$options' => 'i']],
                ['url' => ['$regex' => $search, '$options' => 'i']]
            ]
        ])->toArray();
        if (empty($allData)) {
            echo json_encode(['success' => false, 'message' => 'No Data Found']);
            return;
        }
        echo json_encode(['success' => true, 'message' => "Filtered by search $search", 'data' => $allData]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
    }
}

$search = $_GET['search'];
filteredByAny($collection, $search);
?>