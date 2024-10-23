<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TVRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TvType;
use App\Entity\TV;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/tv')]
class TvController extends AbstractController
{
    #[Route('/test', name: 'app_tv')]
    public function index(): Response
    {
        return $this->render('tv/index.html.twig', [
            'controller_name' => 'TVController',
        ]);
    }

    #[Route('/display', name:"app_display")]
    public function display(TVRepository $rep): Response
    {

        $tvs = $rep->findAll();
        return $this->render('tv/display.html.twig', [
            'tvs' => $tvs,
        ]);
    }
    
    #[Route('/update/{id}', name: 'update_tv')]
public function updateTV(ManagerRegistry $doctrine, Request $request, TVRepository $rep, $id): Response
{
    $em = $doctrine->getManager();
    $tv = $rep->find($id);

    if (!$tv) {
        throw $this->createNotFoundException('No tv found for id ' . $id);
    }

    $form = $this->createForm(TvType::class, $tv);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('app_display');
    }

    return $this->render('tv/update.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
