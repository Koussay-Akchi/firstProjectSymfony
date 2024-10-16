<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AuthorType;
use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/author')]
class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    /**
 * @Route("/service/{name}", name="service_show")
 */
     #[Route('/service/{name}', name:"service_show")]
    public function showService(string $name): Response
    {
        return $this->render('service/showService.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/display', name:"app_display")]
    public function display(AuthorRepository $rep): Response
    {

        $authors = $rep->findAll();
        return $this->render('author/display.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/delete/{id}', name:"delete")]
    public function delete(AuthorRepository $rep , $id, EntityManagerInterface $em): Response
    {
        $author = $rep->find($id);


    if (!$author) {
        $this->addFlash('error', 'Author not found');
        return $this->redirectToRoute("app_display");
    }

        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("app_display");
    }

    #[Route('/add', name:"add_author")]
    public function addAuthor(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $author = new author(); 
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();
            
        return $this->redirectToRoute("app_display");
        
        }

        return $this->render('author/add.html.twig', [
            'f' => $form
        ]);


    }

}