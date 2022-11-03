<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Command;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $user1 = new User();
        $user1->setName("user1");
        $em->persist($user1);
        $user2 = new User();
        $user2->setName("user2");
        $em->persist($user2);
        $em->flush();

        $p1 = new Product();
        $p1
            ->setUser($user1)
            ->setWording("produit1")
            ->setPrice("55.3");
        $em->persist($p1);
        $p2 = new Product();
        $p2
            ->setUser($user2)
            ->setWording("produit2")
            ->setPrice("22.3");
        $em->persist($p2);
        $em->flush();

        $c1 = new Command();
        $c1->setDescription("commande1");
        $c1->addProduct($p1);
        $c1->addProduct($p2);
        $em->persist($c1);

        $c2 = new Command();
        $c2->setDescription("commande2");
        $c2->addProduct($p2);
        $em->persist($c2);
        $em->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }

    /**
     * @Route("/")
     */
    public function home(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $allcommands = $em->getRepository(Command::class)->findAll();
        /*
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'data' => 'src/Controller/HomeController.php',
        ]);*/

        return $this->json($allcommands,200 ,[],['groups'=>"groupencrypt"]);
    }
}
