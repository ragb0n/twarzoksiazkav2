<?php

namespace App\Controller;

use App\Entity\UserPost;
use App\Form\PostFormType;
use App\Repository\FriendshipRepository;
use App\Repository\UserPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends AbstractController
{
    private $userPostRepository;
    private $friendshipRepository;
    private $em;

    public function __construct(UserPostRepository $userPostRepository, FriendshipRepository $friendshipRepository, EntityManagerInterface $em)
    {
        $this->userPostRepository = $userPostRepository;
        $this->friendshipRepository = $friendshipRepository;
        $this->em = $em;
    }

    #[Route('/feed', name: 'feed')]
    public function index(Request $request): Response
    {
        $friendsIds = $this->friendshipRepository->findAllUserFriends(7); //jako parametr ma być ID zalogowanego obecnie użytkownika, dopóki nie zaimplementowano logowania - na sztywno ID = 7
        $posts = $this->userPostRepository->getFeedPosts($friendsIds);

        $post = new UserPost();
        $form = $this->createForm(PostFormType::class, $post);
                
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: dodanie klucza obcego userId użytkownika, któy jest zalogowany
            $newPost = $form->getData();
            $this->em->persist($newPost);
            $this->em->flush();
            // Redirect to prevent form resubmission on page refresh
            return $this->redirectToRoute('feed');
        }

        return $this->render('feed/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }

    #
}