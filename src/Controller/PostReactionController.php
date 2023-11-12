<?php

namespace App\Controller;

use App\Entity\PostReaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostReactionRepository;
use App\Repository\UserPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostReactionController extends AbstractController
{
    private $userPostRepository;
    private $postReactionRepository;
    private $em;

    public function __construct(
        UserPostRepository $userPostRepository, 
        PostReactionRepository $postReactionRepository,
        EntityManagerInterface $em)
    {
        $this->userPostRepository = $userPostRepository;
        $this->postReactionRepository = $postReactionRepository;
        $this->em = $em;
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
