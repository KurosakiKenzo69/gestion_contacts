<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListContactController extends AbstractController
{
    #[Route('/contacts', name: 'app_list_contact')]
    public function index(): Response
    {
        return $this->render('list_contact/index.html.twig', [
            'controller_name' => 'ListContactController',
        ]);
    }
}
