<?php

namespace App\Controller\Admin;

use App\Form\PropertyType;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminControllerProperty extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(PropertyRepository $repository, EntityManagerInterface $em )
    {
        $this->repository = $repository;
        $this->em = $em;
        
        
    }

    /**
     * @Route ("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('Admin/Property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */

    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('succes', 'Créé avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('Admin/Property/new.html.twig', [
            'property' => $property,

            // createView méthode qui créer un objet de type vue
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('succes', 'Modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('Admin/Property/edit.html.twig', [
            'property' => $property,

            // createView méthode qui créer un objet de type vue
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route ("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request) 
    {
        // Je fais une condition pour vérifier si le token est valid via la requête ( c'est un sécurité pour éviter une injection)
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {

            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('succes', 'Supprimé avec succès');
            return new Response('suppression');
        }
        
        return $this->redirectToRoute('admin.property.index');

    }
    
}