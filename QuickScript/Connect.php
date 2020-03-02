<?php

    require_once 'vendor/autoload.php';
    use GraphAware\Neo4j\Client\ClientBuilder;

    class Connect
    {
        protected $client;

    public function __construct()
    {

        $this->client = ClientBuilder::create()
            ->addConnection('default', 'http://neo4j:jack@localhost:7474') // Example for HTTP connection configuration (port is optional)
            ->addConnection('bolt', 'bolt://neo4j:jack@localhost:7687') // Example for BOLT connection configuration (port is optional)
            ->build();
    }

    public function run($query){
        return $result = $this->client->run($query);

    }



}