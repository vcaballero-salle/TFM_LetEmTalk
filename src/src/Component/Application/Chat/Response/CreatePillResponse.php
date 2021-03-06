<?php


namespace LetEmTalk\Component\Application\Chat\Response;


use LetEmTalk\Component\Domain\Authorization\Service\UserPermission;
use LetEmTalk\Component\Domain\Chat\Entity\Pill;

class CreatePillResponse
{
    private Pill $pill;
    private UserPermission $userPermissions;

    public function __construct(Pill $pill, UserPermission $userPermissions)
    {
        $this->pill = $pill;
        $this->userPermissions = $userPermissions;
    }

    public function getPillAsArray(): array
    {
        return [
            "id" => $this->pill->getId(),
            "text" => $this->pill->getText(),
            "authorId" => $this->pill->getAuthor()->getId(),
            "firstNameAuthor" => $this->pill->getAuthor()->getFirstName(),
            "lastNameAuthor" => $this->pill->getAuthor()->getLastName(),
            "createAt" => $this->pill->getCreateAt()->format(\DateTime::ATOM),
            "allowUpdate" => $this->userPermissions->hasUpdatePillPermission($this->pill),
            "allowDelete" => $this->userPermissions->hasDeletePillPermission($this->pill)
        ];
    }
}