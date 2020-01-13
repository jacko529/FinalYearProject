<?php

namespace App\Controller;


use App\Entity\User;
use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



class UserController extends AbstractController
{

    protected object $em;

    public function __construct(EntityManagerInterface $em
                                )
    {
        $this->em = $em;

    }

    public function create(Request $request){
        $user = new User();
        return JsonResponse::create($user, 200);
    }


    public function update(){
        return JsonResponse::create('hello', 200);
    }


    public function delete(){
        return JsonResponse::create('hello', 200);
    }


    public function read(){
        return JsonResponse::create('hello', 200);
    }


    /**
     *
     * @return JsonResponse
     */
    public function index(Request $request){
        $bart = new User();
        $bart->setName($request->get('name', 'default_value'));
        $bart->setAge($request->get('age'));
        $bart->setPassword($request->get('password'));
        $this->em->persist($bart);
        $this->em->flush();

        return $this->json($bart, 200);
    }
}