<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Url;
use App\Repository\UrlRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Attributes\IsGranted;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => 'userRepo',
        ]);
    }

    #[Route('/bahalorsmonreufonaunpetitbangala', name: 'app_bangala')]
    public function bangala(): Response
    {
        return $this->render('troll/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/espaceperso', name: 'app_admin')]
    #[IsGranted("ROLE_USER")]
    public function espaceperso(UrlRepository $urlRepo): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            // Utilisateur non autorisé, redirection vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
    
        // Récupérer les liens générés par l'utilisateur
        $userLinks = $urlRepo->findBy(['user' => $this->getUser()]);
    
        return $this->render('espaceperso/index.html.twig', [
            'controller_name' => 'HomeController',
            'userLinks' => $userLinks,
        ]);
    }
    
}
