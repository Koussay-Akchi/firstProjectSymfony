<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/book")
 */
#[Route('book')]
class BookController extends AbstractController
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
    public function display(BookRepository $rep): Response
    {

        $books = $rep->findAll();
        return $this->render('book/display.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/delete/{id}', name:"delete")]
    public function delete(BookRepository $rep , $id, EntityManagerInterface $em): Response
    {
        $book = $rep->find($id);

        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("app_display");
    }

}