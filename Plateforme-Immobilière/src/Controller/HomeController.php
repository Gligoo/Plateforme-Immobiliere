<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route ("/", name="index")
     * @return Response
     */

    public function index(PropertyRepository $repository): Response
    {
        $properties = $repository->findLast();
        return $this->render('Pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}