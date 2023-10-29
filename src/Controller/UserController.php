<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    #[Route('/user/{userid}', name: 'user', defaults: ['userid' => null], methods:['GET', 'HEAD'])]
    public function index($userid): Response
    {
        $users = ["0001", "0002", "0003", "0004"];

        return $this->render('index.html.twig', [
            'userids' => $users
        ]);
    }

}
