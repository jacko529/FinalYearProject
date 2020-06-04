<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class => ['all' => true],
    SymfonyBundles\JsonRequestBundle\SymfonyBundlesJsonRequestBundle::class => ['all' => true],
    K911\Swoole\Bridge\Symfony\Bundle\SwooleBundle::class => ['all' => true],
    Neo4j\Neo4jBundle\Neo4jBundle::class => ['all' => true],
];
