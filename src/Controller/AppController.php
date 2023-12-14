<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route(path:'/')]
    public function home(): Response
    {
        // return new Response('Hello world');

        return $this->render('app/home.html.twig');
    }
}