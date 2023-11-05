<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $middleName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $mobile = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $joinDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bio = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: UserPost::class)]
    private Collection $userPosts;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Photo::class, orphanRemoval: true)]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: 'sourceUserId', targetEntity: Friendship::class, orphanRemoval: true)]
    private Collection $friendships;

    #[ORM\OneToMany(mappedBy: 'sourceUserId', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: PostComment::class, orphanRemoval: true)]
    private Collection $postComments;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: PostReaction::class)]
    private Collection $postReactions;

    public function __construct()
    {
        $this->userPosts = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->friendships = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->postComments = new ArrayCollection();
        $this->postReactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): static
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getJoinDate(): ?\DateTimeInterface
    {
        return $this->joinDate;
    }

    public function setJoinDate(\DateTimeInterface $joinDate): static
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection<int, UserPost>
     */
    public function getUserPosts(): Collection
    {
        return $this->userPosts;
    }

    public function addUserPost(UserPost $userPost): static
    {
        if (!$this->userPosts->contains($userPost)) {
            $this->userPosts->add($userPost);
            $userPost->setUserId($this);
        }

        return $this;
    }

    public function removeUserPost(UserPost $userPost): static
    {
        if ($this->userPosts->removeElement($userPost)) {
            // set the owning side to null (unless already changed)
            if ($userPost->getUserId() === $this) {
                $userPost->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setUserId($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getUserId() === $this) {
                $photo->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships(): Collection
    {
        return $this->friendships;
    }

    public function addFriendship(Friendship $friendship): static
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships->add($friendship);
            $friendship->setSourceUserId($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): static
    {
        if ($this->friendships->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getSourceUserId() === $this) {
                $friendship->setSourceUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSourceUserId($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSourceUserId() === $this) {
                $message->setSourceUserId(null);
            }
        }

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
            $postComment->setUserId($this);
        }

        return $this;
    }

    public function removePostComment(PostComment $postComment): static
    {
        if ($this->postComments->removeElement($postComment)) {
            // set the owning side to null (unless already changed)
            if ($postComment->getUserId() === $this) {
                $postComment->setUserId(null);
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
            $postReaction->setUserId($this);
        }

        return $this;
    }

    public function removePostReaction(PostReaction $postReaction): static
    {
        if ($this->postReactions->removeElement($postReaction)) {
            // set the owning side to null (unless already changed)
            if ($postReaction->getUserId() === $this) {
                $postReaction->setUserId(null);
            }
        }

        return $this;
    }
}
