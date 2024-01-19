<?php
namespace app\core\db;

use Elastic\Elasticsearch\ClientBuilder;

class Elastic
{
    protected static $client;
    private function __construct(){}

    public static function getInstance(){
        if(!self::$client){
            self::$client = ClientBuilder::create()
                ->setHosts(['es:9200'])
                ->build();
        }
        return self::$client;
    }
}