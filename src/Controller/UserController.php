<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSearchType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    //wszyscy użytkownicy
    #[Route('/', name: 'users', methods: ['GET'])]
    public function index(): Response{
        $users = $this->userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/{userid}', name: 'user_profile', methods: ['GET'])]
    public function show($userid): Response{
        $user = $this->userRepository->find($userid);

        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/users/search', name: 'user_search')]
    public function search(Request $request): Response{
        $form = $this->createForm(UserSearchType::class); //tworzymy formularz zgodnie z tym, co zdefiniowano w UserSearchType
        $form->handleRequest($request); //przetwarzanie danych, żądania HTTP po wysłania formularza

        $users = []; //pusta arrayka do przechowywania wyników wyszukiwania

        if ($form->isSubmitted() && $form->isValid()) {
            $searchKeyword = $form->get('searchKeyword')->getData(); //do zmiennej przypisuje to, co znalazło się w polu 'searchKeyword' formularza
            $users = $this->userRepository->findBySearchKeyword($searchKeyword); //do zmiennej przypisuje wyniki wyszukiwania, tj wynik działania funkcji findBySearchKeyword dla wartości z formularza
        }

        return $this->render('user/search.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
}
