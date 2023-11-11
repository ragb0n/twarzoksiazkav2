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

    #[Route('/post/{postId}/react', name: 'user_post_react', methods:['POST'])]
    public function react(Request $request, $postId)
    {
        $user = $this->getUser(); //aktualnie zalogowany user
        $reactionType = $request->request->get('type'); //z żądania AJAX pobiera info, jakiego typu reakcja została dodana
        $post = $this->userPostRepository->find($postId); //post dla ktorego dodano reakcję

        if(!$post || !$user){  //jeżeli nie ustawiono aktualnie zalogowanego usera (niezalogowany) lub postu dla któego dodano reakcję - wywal błąd
            return new JsonResponse(['error' => 'Invalid post or user.'], 400);
        }

        //znajduje reakcję wystawioną już do danego posta przez danego użytkownika i przypisuje ją do zmiennej
        $existingReaction = $this->postReactionRepository->findOneBy([
            'postId' => $post,
            'userId' => $user,
        ]); 

        if($existingReaction && $existingReaction->getType() == $reactionType){ //jeżeli znaleziono już istniejąca reakcję oraz jest one tego samego typu, co w żądaniu - usuń reakcję
            $this->em->remove($existingReaction);
        }else{
            if(!$existingReaction){ //jeżeli nie ma żadnej reakcji do postu - utwórz nową
                $newReaction = new PostReaction();
                $newReaction->setUserId($user);
                $newReaction->setPostId($post);
                $newReaction->setType($reactionType);
                $this->em->persist($newReaction);
            }else{
                $existingReaction->setType($reactionType); //jeżeli jest już jakas reakcja ale innego typu - zmień typ reakcji
            }
        }

        $this->em->flush(); //wykonaj mziany w bazie

        $reactionCounts = $this->postReactionRepository->getReactionCounts($postId); //pobierz ilość reakcji każdego typu do postu
        return new JsonResponse(['reactions' => $reactionCounts]);
    }



    
}