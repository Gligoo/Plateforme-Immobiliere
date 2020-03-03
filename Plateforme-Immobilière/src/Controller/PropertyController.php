<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use PhpParser\Node\Stmt\Use_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends AbstractController
{

    /**
     * $var PropertyRespository
     */
    private $repository;

    
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
        
    }

    /**
     * @Route ("/biens", name="property.index")
     * @return Response
     */

    public function index(): Response
    {

        //ON COMMENTE CAR ON NE VEUT PAS CREER DES TONNES DE BIENS, ON VAS LE RECUPERER DIFFEREMENT.

        // $property = new Property();
        // $property->setTitle('Mon premier bien')
        //     ->setPrice(200000)
        //     ->setRooms(4)
        //     ->setDescription('une petite description')
        //     ->setSurface(60)
        //     ->setFloor(4)
        //     ->setHeat(1)
        //     ->setCity('Paris')
        //     ->setAdress('15 Boulevard Gambetta')
        //     ->setPostalCode('75000');
        // // J'utilise entity manager de Abstract pour envoyer en base de donnée l'entitée
        // // je sauvegarde le manager ds une varibale 
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // //  flush permet de porter tous les changements de l'entity manager dans la BDD
        // $em->flush();


        // Une methode pr récupérer mais on vas utiliser plutôt l'autowiring

        // $repository = $this->getDoctrine()->getRepository( Property::class);
        // dump($repository);

        return $this->render('Property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[(a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug){
            // renvoi tjs vers le lien , très important pr le référencement !
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        
        return $this->render('Property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}
