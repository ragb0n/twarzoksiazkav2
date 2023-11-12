<?php

namespace App\Controller;

use App\Entity\PostReaction;
use App\Entity\UserPost;
use App\Form\PostFormType;
use App\Repository\FriendshipRepository;
use App\Repository\PostReactionRepository;
use App\Repository\UserPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserPostController extends AbstractController
{
    private $userPostRepository;
    private $friendshipRepository;
    private $postReactionRepository;
    private $em;

    public function __construct(
        UserPostRepository $userPostRepository, 
        FriendshipRepository $friendshipRepository, 
        PostReactionRepository $postReactionRepository,
        EntityManagerInterface $em)
    {
        $this->userPostRepository = $userPostRepository;
        $this->friendshipRepository = $friendshipRepository;
        $this->postReactionRepository = $postReactionRepository;
        $this->em = $em;
    }

    #[Route('/feed', name: 'feed')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $friendsIds = $this->friendshipRepository->findAllUserFriends($userId);
        array_push($friendsIds, $userId);
        $posts = $this->userPostRepository->getFeedPosts($friendsIds);

        $reactions = [];
        foreach($posts as $post){
            $reactions[$post->getId()] = $this->postReactionRepository->getReactionCounts($post->getId());
        }

        $post = new UserPost(); //utworzenie nowego posta
        $form = $this->createForm(PostFormType::class, $post); //tworzenie formularza który dostarczy dane dla nowego posta
                
        $form->handleRequest($request); //obsługa objektu Request, który zawiera m.in. formularz

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: dodanie klucza obcego userId użytkownika, któy jest zalogowany
            $newPost = $form->getData();
            $post->setUserId($user);
            $this->em->persist($newPost); //deklarowanie Doctrine, że "potencjalnie" możliwe jest, że zostanie dokonany nowy wpis do bazy
            $this->em->flush(); //wykonaj zapytanie z dodaniem wpisu do bazy (INSERT)
            // Redirect to prevent form resubmission on page refresh
            return $this->redirectToRoute('feed');
        }
        
        return $this->render('feed/index.html.twig', [
            'posts' => $posts,
            'reactions' => $reactions,
            'form' => $form->createView()
        ]);
    }
}