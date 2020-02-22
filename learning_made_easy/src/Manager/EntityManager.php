<?php


namespace App\Manager;

use GraphAware\Neo4j\OGM\EntityManager as BaseEntityManager;

class EntityManager
{
    protected $entityManager;

    public function __construct()
    {
        $this->entityManager = BaseEntityManager::create('http://neo4j:jack@neo4j:7687');
    }

    /**
     * @return BaseEntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}