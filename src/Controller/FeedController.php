<?php

namespace App\Controller;

use App\Repository\FriendshipRepository;
use App\Repository\UserPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    private $userPostRepository;
    private $friendshipRepository;

    public function __construct(UserPostRepository $userPostRepository, FriendshipRepository $friendshipRepository)
    {
        $this->userPostRepository = $userPostRepository;
        $this->friendshipRepository = $friendshipRepository;
    }

    #[Route('/feed', name: 'feed')]
    public function index(): Response
    {
        $friendsIds = $this->friendshipRepository->findAllUserFriends(7); //jako parametr ma być ID zalogowanego obecnie użytkownika, dopóki nie zaimplementowano logowania - na sztywno ID = 7
        $posts = $this->userPostRepository->getFeedPosts($friendsIds);

        return $this->render('feed/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}