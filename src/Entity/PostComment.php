<?php

namespace App\Entity;

use App\Repository\PostCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCommentRepository::class)]
class PostComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserPost $postId = null;

    #[ORM\ManyToOne(inversedBy: 'postComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostId(): ?UserPost
    {
        return $this->postId;
    }

    public function setPostId(?UserPost $postId): static
    {
        $this->postId = $postId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
