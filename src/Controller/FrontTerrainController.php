<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/frontTerrain")
 */
class FrontTerrainController extends AbstractController
{
    /**
     * @Route("/",name="terrainFront_index", methods={"GET"})
     */
    public function index(TerrainRepository $terrainRepository): Response
    {
        return $this->render('front_terrain/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }
    /**
     * @Route("/add", name="terrain_add", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($terrain);
            $images = $form->get('imageTerrain')->getData();
            //o boucle sur les images
            foreach ($images as $image)  {
                //on génère un nouveau nom de fichier
                $file = md5(uniqid()). '.' . $image->guessExtension();
                //on va copier le fichier dans le doc uploads par move
                $image->move(
                    $this->getParameter('terrain_directory'),
                    $file
                );
                //on va stocker l'image dans la base de donnée(image est stocké sur le disque
                // et son nom dans la base de donnée
                $terrain->setImageTerrain($file);
            }
            $entityManager->flush();

            return $this->redirectToRoute('terrainFront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front_terrain/FrontNew.html.twig', [
            'terrain' => $terrain,
            'form' => $form->createView(),
        ]);
    }

}
