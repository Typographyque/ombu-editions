<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var LivreRepository
     */
    private $repository;

    public function __construct(LivreRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index(): Response
    {

        $livres = $this->repository->findAll();

        return $this->render('admin/index.html.twig', [
            'livres' => $livres
        ]);
    }

    /**
     * @Route("/admin/livre/create", name="livre.new")
     */
    public function new(Request $request)
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($livre);
            $this->manager->flush();
            $this->addFlash('success', "Le livre a bien été créé");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/livre.new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/livre/{id}", name="livre.edit", methods={"GET|POST"})
     * @param Livre $livre
     * @param Request $request
     * @return Response
     */
    public function edit(Livre $livre, Request $request)
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->flush();
            $this->addFlash('success', "Le livre a bien été modifié");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/livre.edit.html.twig', [
           'livre' => $livre,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/livre/{id}", name="livre.delete", methods={"DELETE"})
     * @param Livre $livre
     * @return Response
     */
    public function delete(Livre $livre, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $livre->getId(), $request->get('_token'))) {
            $this->manager->remove($livre);
            $this->manager->flush();
            $this->addFlash('success', "Le livre a bien été suprimé");
        }

        return $this->redirectToRoute('admin');
    }


}
