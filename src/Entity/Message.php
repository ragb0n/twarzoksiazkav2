<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $sourceUserId = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $targetUserId = null;

    #[ORM\Column(length: 255)]
    private ?string $messageText = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceUserId(): ?User
    {
        return $this->sourceUserId;
    }

    public function setSourceUserId(?User $sourceUserId): static
    {
        $this->sourceUserId = $sourceUserId;

        return $this;
    }

    public function getTargetUserId(): ?User
    {
        return $this->targetUserId;
    }

    public function setTargetUserId(?User $targetUserId): static
    {
        $this->targetUserId = $targetUserId;

        return $this;
    }

    public function getMessageText(): ?string
    {
        return $this->messageText;
    }

    public function setMessageText(string $messageText): static
    {
        $this->messageText = $messageText;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): static
    {
        $this->createDate = $createDate;

        return $this;
    }
}
