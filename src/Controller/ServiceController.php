<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

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
    
    #[Route('/display2', name:"app_display2")]
    public function display2(BookRepository $rep): Response
    {

        $books = $rep->findAll();
        return $this->render('book/display.html.twig', [
            'books' => $books,
        ]);
    }


    #[Route('/delete/{id}', name:"delete")]
    public function delete(AuthorRepository $rep , $id, EntityManagerInterface $em): Response
    {
        $author = $rep->find($id);

        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("app_display");
    }

}