<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactRepository;
use App\Form\ContactType;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/creer/contact', name: 'app_contact')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            
            $this->addFlash('success', 'Le contact a été ajouté avec succès !');
            return $this->redirectToRoute('app_contact_list');
        }
        
        return $this->render('contact/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('liste/contacts', name: 'app_contact_list')]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        
        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts
        ]);
    }

    #[Route('/modifier/contact/{id}', name: 'app_contact_edit')]
    public function edit(Contact $contact, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Le contact a été modifié avec succès !');
            return $this->redirectToRoute('app_contact_list');
        }
        
        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}