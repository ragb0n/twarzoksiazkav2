<?php

namespace App\Entity;

use App\Repository\PostReactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostReactionRepository::class)]
class PostReaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postReactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserPost $postId = null;

    #[ORM\ManyToOne(inversedBy: 'postReactions')]
    private ?User $userId = null;

    #[ORM\Column]
    private ?int $type = null;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }
}
