<?php

namespace App\Controller;

use App\Entity\LignePanier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LignePanierController extends AbstractController
{
    /**
     * @Route("/ligne/panier", name="ligne_panier")
     */
    public function index(): Response
    {
        return $this->render('ligne_panier/index.html.twig', [
            'controller_name' => 'LignePanierController',
        ]);
    }
}
