<?php

namespace App\Entity;

use App\Repository\UserPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPostRepository::class)]
class UserPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'postId', targetEntity: PostComment::class, orphanRemoval: true)]
    private Collection $postComments;

    #[ORM\OneToMany(mappedBy: 'postId', targetEntity: PostReaction::class, orphanRemoval: true)]
    private Collection $postReactions;

    public function __construct()
    {
        $this->postComments = new ArrayCollection();
        $this->postReactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, PostComment>
     */
    public function getPostComments(): Collection
    {
        return $this->postComments;
    }

    public function addPostComment(PostComment $postComment): static
    {
        if (!$this->postComments->contains($postComment)) {
            $this->postComments->add($postComment);
            $postComment->setPostId($this);
        }

        return $this;
    }

    public function removePostComment(PostComment $postComment): static
    {
        if ($this->postComments->removeElement($postComment)) {
            // set the owning side to null (unless already changed)
            if ($postComment->getPostId() === $this) {
                $postComment->setPostId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostReaction>
     */
    public function getPostReactions(): Collection
    {
        return $this->postReactions;
    }

    public function addPostReaction(PostReaction $postReaction): static
    {
        if (!$this->postReactions->contains($postReaction)) {
            $this->postReactions->add($postReaction);
            $postReaction->setPostId($this);
        }

        return $this;
    }

    public function removePostReaction(PostReaction $postReaction): static
    {
        if ($this->postReactions->removeElement($postReaction)) {
            // set the owning side to null (unless already changed)
            if ($postReaction->getPostId() === $this) {
                $postReaction->setPostId(null);
            }
        }

        return $this;
    }
}
