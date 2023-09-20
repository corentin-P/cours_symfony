<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game')]
    public function index(GameRepository $gameRepository): Response
    {
        $entities = $gameRepository->findAlpha();

        return $this->render('game/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    // Injection de dépendance: SF va m'envoyer les objets dont j'ai besoin en paramètre
    #[Route('/game/new')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $entity = new Game();
        //$entity->setName('Tetris');
        //$entity->setDescription('');

        // Chargement du formulaire et envois de l'entité game pour initialiser les données 
        $form = $this->createForm(GameType::class, $entity);
        // Permet d'envoyer les données POST dans le formulaire
        $form->handleRequest($request); // on POST le formulaire

        if ($form->isSubmitted() && $form->isValid()){
            // Indique à Doctrine de prendre en charge cet objet
            // Prepare la requête
            $entityManager->persist($entity);

            $entityManager->flush(); // Exécute la requête

            return $this->redirectToRoute('app_game_index');
        }



        return $this->render('game/new.html.twig', [
            'gameForm' => $form->createView(), // envois du formulaire dans la vue 
        ]);
    }

    // {id} est un param qui est un nb de 1 ou plusieurs chiffres
    // Grace au Param Converter, Symfony va faire automatiquement une requete pour récupérer le jeu en fonction de l'id
    #[Route('/game/{id<\d+>}/edit')]
    public function edit(game $entity):Response
    {
        
    }
}
