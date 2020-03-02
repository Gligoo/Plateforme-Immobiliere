<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends AbstractController
{
    /**
     * @Route ("/biens", name="property.index")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('Property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}
