<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ShopType;
use App\Entity\Shop;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/shop')]
class ShopController extends AbstractController
{
    #[Route('/test', name: 'app_shop')]
    public function index(): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }

    #[Route('/display', name:"app_display")]
    public function display(EntityManagerInterface $entityManager): Response
    {
        $shops = $entityManager->getRepository(Shop::class)->findAll();
        return $this->render('shop/display.html.twig', [
            'shops' => $shops,
        ]);
    }

}
