<?php

use Elastic\Elasticsearch\ClientBuilder;

define('BASE_PATH', dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

$client = ClientBuilder::create()
    ->setHosts(['es:9200'])
    ->build();

$index = 'engineering-assessment';
$deleteParams = [
    'index' => $index
];

try {
    $response = $client->indices()->delete($deleteParams)->asArray();
    if (isset($response['acknowledged']) && $response['acknowledged'] == 1) {
        echo 'Deleting the elasticsearch index \'', $index, '\' was successful', PHP_EOL;
    } else {
        echo 'Failed to delete elasticsearch index \'', $index, '\'', PHP_EOL;
    }
} catch (Exception $e) {
    printf("Failed to delete elasticsearch index '$index', error: %s\n", $e->getMessage());
}

try {
    $params = [
        'index' => $index,
        'body' => [
            'settings' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0
            ],
            'mappings' => [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => [
                    'locationid' => [
                        'type' => 'integer'
                    ],
                    'Applicant' => [
                        'type' => 'text'
                    ],
                    'FacilityType' => [
                        'type' => 'text',
                    ],
                    'cnn' => [
                        'type' => 'integer',
                    ],
                    'LocationDescription' => [
                        'type' => 'text',
                    ],
                    'Address' => [
                        'type' => 'text',
                    ],
                    'blocklot' => [
                        'type' => 'text',
                    ],
                    'block' => [
                        'type' => 'text',
                    ],
                    'lot' => [
                        'type' => 'text',
                    ],
                    'permit' => [
                        'type' => 'text',
                    ],
                    'Status' => [
                        'type' => 'text',
                    ],
                    'FoodItems' => [
                        'type' => 'text',
                    ],
                    'X' => [
                        'type' => 'integer',
                    ],
                    'Y' => [
                        'type' => 'integer',
                    ],
                    'Latitude' => [
                        'type' => 'float',
                    ],
                    'Longitude' => [
                        'type' => 'float',
                    ],
                    'Schedule' => [
                        'type' => 'text',
                    ],
                    'dayshours' => [
                        'type' => 'text',
                    ],
                    'NOISent' => [
                        'type' => 'text',
                    ],
                    'Approved' => [
                        "type" => "date",
                        "format" => "MM/dd/yyyy h:mm:ss a",
                        'ignore_malformed' => true
                    ],
                    'Received' => [
                        'type' => 'integer',
                    ],
                    'PriorPermit' => [
                        'type' => 'integer',
                    ],
                    'ExpirationDate' => [
                        "type" => "date",
                        "format" => "MM/dd/yyyy h:mm:ss a",
                        'ignore_malformed' => true
                    ],
                    'Location' => [
                        "type" => "geo_point"
                    ],
                    'Fire Prevention Districts' => [
                        'type' => 'text',
                    ],
                    'Police Districts' => [
                        'type' => 'text',
                    ],
                    'Supervisor Districts' => [
                        'type' => 'text',
                    ],
                    'Zip Codes' => [
                        'type' => 'text',
                    ],
                    'Neighborhoods (old)' => [
                        'type' => 'text',
                    ]
                ]
            ]
        ]
    ];
    $response = $client->indices()->create($params)->asArray();
    if (isset($response['acknowledged']) && $response['acknowledged'] == 1) {
        echo 'The elasticsearch index \'', $index, '\' was created successfully', PHP_EOL;
    } else {
        echo 'Failed to create elasticsearch index \'', $index, '\'', PHP_EOL;
    }
} catch (Exception $e) {
    printf("Failed to create elasticsearch index '$index', error: %s\n", $e->getMessage());
    exit;
}

if (($handle = fopen(__DIR__ . "/../Mobile_Food_Facility_Permit.csv", "r")) !== FALSE) {
    $i = 0;
    $key = [];
    while (($value = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($i === 0) {
            $key = $value;
        } else {
            $data = array_combine($key, $value);

            $latitude = $longitude = 0;
            if (preg_match('/(\d+\.\d+),\s*(-?\d+\.\d+)/', $data['Location'], $matches)) {
                $latitude = $matches[1];
                $longitude = $matches[2];
            }

            $data['Location'] = [
                "lat" => $latitude,
                "lon" => $longitude
            ];

            $data['FoodItems'] = explode(': ', $data['FoodItems']);
            $params = [
                'index' => $index,
                'id' => $data['locationid'],
                'timestamp' => strtotime("-1d"),
                'body' => $data
            ];
            $client->index($params)->asArray();
        }
        $i++;
    }
    fclose($handle);
}
echo 'the data have import to elasticsearch', PHP_EOL;