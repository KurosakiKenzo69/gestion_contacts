<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactRepository;
use App\Form\ContactType;
use App\Form\EditContactType;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    // Créer un contact
    #[Route('/creer/contact', name: 'app_contact_create')]
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

    // Lister les contacts
    #[Route('/', name: 'app_contact_list')]
    public function index(ContactRepository $contactRepository, Request $request): Response
    {
        $search = $request->query->get('q');
        $sort = $request->query->get('sort', 'nom'); // Tri par défaut : nom
        $direction = $request->query->get('direction', 'asc');

        // Si une recherche est faite, utiliser search(), sinon récupérer tous les contacts triés
        if ($search) {
            $contacts = $contactRepository->search($search);
        } else {
            $contacts = $contactRepository->orderByField($sort, $direction);
        }

        $count = $contactRepository->countAllContacts();

        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts,
            'count' => $count,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }


    // Suppression d'un contact
    #[Route('/supprimer/contact/{id}', name: 'app_contact_delete')]
    public function delete(int $id, ContactRepository $contactRepository): Response
    {
        $contact = $contactRepository->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Contact non trouvé.');
        }
        
        $contactRepository->delete($contact);
        $this->addFlash('success', 'Le contact a été supprimé !');
        
        return $this->redirectToRoute('app_contact_list');
    }

    // Modifier un contact
    #[Route('/modifier/contact/{id}', name: 'app_contact_edit')]
    public function edit(int $id, Request $request, ContactRepository $contactRepository): Response
    {
        // Récupérer le contact
        $contact = $contactRepository->find($id);
        if (!$contact) { 
            throw $this->createNotFoundException('Contact non trouvé.');
        }

        // Créer le formulaire
        $form = $this->createForm(EditContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Utiliser la méthode update() du Repository
            $contactRepository->update($contact);

            // Rediriger vers la liste des contacts
            return $this->redirectToRoute('app_contact_list');
        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact
        ]);
    }
}