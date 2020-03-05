<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
        ]);
    }
}
