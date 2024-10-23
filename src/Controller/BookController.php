<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\BookType;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;

#[Route('book')]
class BookController extends AbstractController
{
    #[Route('/Book', name: 'app_Book')]
    public function index(): Response
    {
        return $this->render('Book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/display', name:"app_display_book")]
    public function displayBooks(BookRepository $rep): Response
    {
        #$books = $entityManager->getRepository(Book::class)->findAll();
        $books = $rep->findAll();
        return $this->render('book/display.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/delete/{id}', name:"delete_book")]
    public function deleteBooks(BookRepository $rep , $id, EntityManagerInterface $em): Response
    {
        $book = $rep->find($id);

        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("app_display_book");
    }

    #[Route('/add', name:"add_book")]
    public function addBook(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $book = new book(); 
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();
            
        return $this->redirectToRoute("app_display_book");
        
        }

        return $this->render('book/add.html.twig', [
            'f' => $form
        ]);
    }
}
