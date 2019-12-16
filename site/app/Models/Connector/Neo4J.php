<?php
namespace App\Models\Connector;


use GraphAware\Neo4j\Client\ClientBuilder;
use Illuminate\Config\Repository;


trait Neo4J
{

    protected $client;

    public function connect()
    {

        $this->client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:' . env('NEO4J_Password') . '@' . env('NEO4J_Host')  . ':' . env('NEO4J_Port') . '') // Example for BOLT connection configuration (port is optional)
            ->build();

        return $this->client;

    }

}
