<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class FriendshipController extends AbstractController
{
    private $friendshipRepository;
    private $userRepository;
    private $em;

    public function __construct(
        FriendshipRepository $friendshipRepository,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ){
        $this->friendshipRepository = $friendshipRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    #[Route('/friendship/{friendshipId}/remove', name: 'app_friendship', methods: ['POST'])]
    public function removeFriend(Request $request, $friendshipId){
        $friendshipId = $request->request->get('friendship');
        $friendship = $this->friendshipRepository->find($friendshipId);
        
        if(!$friendship){
            return new JsonResponse(['error' => 'You are not friends'], 400);
        }

        $this->em->remove($friendship);
        $this->em->flush();

        return new JsonResponse(['response' => 'Usunięto']);
    }

    #[Route('friendship/{targetUserId}/add', name: 'app_friendship_add', methods: ['POST'])]
    public function addFriend(Request $request, $targetUserId){
        $user = $this->getUser();

        $targetUserId = $request->request->get('target');
        
        $targetUser = $this->userRepository->find($targetUserId);

        $newFriendship = new Friendship();
        $newFriendship->setSourceUserId($user);
        $newFriendship->setTargetUserId($targetUser);
        $newFriendship->setStatus(2);
        
        $this->em->persist($newFriendship);
        $this->em->flush();

        return new JsonResponse(['response' => 'Dodano użytkownika']);
    }

}
