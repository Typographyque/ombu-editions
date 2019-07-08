<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\LivreRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function home(LivreRepository $repository): Response
    {

        $livres = $repository->findLasted();

        return $this->render('main/home.html.twig', [
            'livres' => $livres
        ]);
    }

    /**
     * @Route("livres/{slug}-{id}", name="livre", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function livre($slug, $id, LivreRepository $repository): Response
    {
        $livre = $repository->find($id);

        $suivant = $repository->findOneRandom();


        return $this->render('main/livre.html.twig', [
            'livre' => $livre,
            'suivant' =>$suivant,
        ]);
    }

    /**
     * @Route("ombu", name="about")
     * @return Response
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("contact", name="contact")
     * @return Response
     */
    public function contact(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $notification->notify($contact);

            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
}
