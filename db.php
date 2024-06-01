<?php
require 'vendor/autoload.php'; 

use MongoDB\Client;

function getMongoDBCollection()
{
    $connectionString = "mongodb+srv://admin:XvDTuV8lMiPwsLNU@cluster0.lnrder1.mongodb.net/blackcoffer_php?retryWrites=true&w=majority&appName=Cluster0";

    try {
        $client = new Client($connectionString);
        $database = $client->selectDatabase('blackcoffer_php'); 
    
        echo "Connected to MongoDB Atlas successfully!";

        $collectionOptions = [
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['end_year', 'intensity', 'topic', 'title', 'likelihood'],
                    'properties' => [
                        'end_year' => [
                            'bsonType' => 'int',
                            'description' => 'must be an integer and is required'
                        ],
                        'citylng' => [
                            'bsonType' => 'double',
                            'description' => 'must be a double if the field exists'
                        ],
                        'citylat' => [
                            'bsonType' => 'double',
                            'description' => 'must be a double if the field exists'
                        ],
                        'intensity' => [
                            'bsonType' => 'int',
                            'description' => 'must be an integer and is required'
                        ],
                        'sector' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'topic' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string and is required'
                        ],
                        'insight' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'swot' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'url' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'region' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'start_year' => [
                            'bsonType' => 'int',
                            'description' => 'must be an integer if the field exists'
                        ],
                        'impact' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'added' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'published' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'city' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'country' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'relevance' => [
                            'bsonType' => 'int',
                            'description' => 'must be an integer if the field exists'
                        ],
                        'pestle' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'source' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string if the field exists'
                        ],
                        'title' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string and is required'
                        ],
                        'likelihood' => [
                            'bsonType' => 'int',
                            'description' => 'must be an integer and is required'
                        ]
                    ]
                ]
            ]
        ];

        $collections = $database->listCollections();
        $collectionExists = false;
        foreach ($collections as $collection) {
            if ($collection->getName() == 'datamodel') {
                $collectionExists = true;
                break;
            }
        }

        if ($collectionExists) {
            echo "Collection 'datamodel' already exists. Dropping it...\n";
            $database->dropCollection('datamodel');
        }

         $database->createCollection('datamodel', $collectionOptions);
        echo "Collection 'datamodel' created successfully!\n";
        return $database->selectCollection('datamodel'); 
        
    } catch (Exception $e) {
        echo "Failed to connect to MongoDB Atlas: ", $e->getMessage();
    }
}

function getMongoCollection() {
    $connectionString = "mongodb+srv://admin:XvDTuV8lMiPwsLNU@cluster0.lnrder1.mongodb.net/blackcoffer_php?retryWrites=true&w=majority&appName=Cluster0";
   $client = new Client($connectionString);
    $database = $client->selectDatabase('blackcoffer_php'); 
    return $database->selectCollection('datamodel');
}
