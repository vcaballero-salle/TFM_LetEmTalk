<?php


namespace LetEmTalk\Component\Application\Chat\Response;


use LetEmTalk\Component\Domain\Authorization\Service\UserPermission;
use LetEmTalk\Component\Domain\Chat\Entity\Issue;

class CreateIssueResponse
{
    private Issue $issue;
    private UserPermission $userPermissions;

    public function __construct(Issue $issue, UserPermission $userPermissions)
    {
        $this->issue = $issue;
        $this->userPermissions = $userPermissions;
    }

    public function getIssueAsArray(): array
    {
        return [
            "issueId" => $this->issue->getId(),
            "title" => $this->issue->getTitle(),
            "text" => $this->issue->getFirstPill()->getText(),
            "authorId" => $this->issue->getFirstPill()->getAuthor()->getId(),
            "firstNameAuthor" => $this->issue->getFirstPill()->getAuthor()->getFirstName(),
            "lastNameAuthor" => $this->issue->getFirstPill()->getAuthor()->getLastName(),
            "createAt" => $this->issue->getFirstPill()->getCreateAt()->format(\DateTime::ATOM),
            "allowUpdate" => $this->userPermissions->hasUpdateIssuePermission($this->issue),
            "allowDelete" => $this->userPermissions->hasDeleteIssuePermission($this->issue)
        ];
    }
}
