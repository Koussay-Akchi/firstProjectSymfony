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

    #[Route('/show/{id}', name: 'show_author')]
public function showAuthor(AuthorRepository $authorRepository, $id): Response
{
    $author = $authorRepository->find($id);

    return $this->render('author/show.html.twig', [
        'author' => $author,
    ]);
}

#[Route('/show2/{id}', name: 'authorDetails')]
    public function authorDetails(int $id): Response
    {
        $authors = [
            ['id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            ['id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            ['id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];

        $author = null;
        foreach ($authors as $a) {
            if ($a['id'] == $id) {
                $author = $a;
                break;
            }
        }

        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }


    #[Route('/update/{id}', name: 'update_author')]
public function updateAuthor(ManagerRegistry $doctrine, Request $request, AuthorRepository $rep, $id): Response
{
    $em = $doctrine->getManager();
    $author = $rep->find($id);

    if (!$author) {
        throw $this->createNotFoundException('No author found for id ' . $id);
    }

    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('app_display');
    }

    return $this->render('author/update.html.twig', [
        'form' => $form->createView(),
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