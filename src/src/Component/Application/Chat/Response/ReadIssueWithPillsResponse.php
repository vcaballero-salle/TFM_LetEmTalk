<?php


namespace LetEmTalk\Component\Application\Chat\Response;


use LetEmTalk\Component\Domain\Authorization\Service\UserPermission;
use LetEmTalk\Component\Domain\Chat\Entity\Issue;
use LetEmTalk\Component\Domain\Chat\Entity\Pill;

class ReadIssueWithPillsResponse
{
    private Issue $issue;
    private array $pills;
    private UserPermission $userPermissions;

    public function __construct(Issue $issue, array $pills, UserPermission $userPermissions)
    {
        $this->issue = $issue;
        $this->pills = $pills;
        $this->userPermissions = $userPermissions;
    }

    public function getIssueWithPillsAsArray(): array
    {
        usort($this->pills, array($this, "comparePillCreatedAt"));
        return [
            "issue" => $this->getIssueAsArray(),
            "numberOfPills" => count($this->pills),
            "pills" => array_map(array($this, "getPillAsArray"), $this->pills)
        ];
    }

    private function getIssueAsArray(): array
    {
        return [
            "id" => $this->issue->getId(),
            "roomId" => $this->issue->getRoom()->getId(),
            "title" => $this->issue->getTitle(),
            "allowUpdate" => $this->userPermissions->hasUpdateIssuePermission($this->issue),
            "allowDelete" => $this->userPermissions->hasDeleteIssuePermission($this->issue),
            "allowCreatePills" => $this->userPermissions->hasCreatePillPermission($this->issue)
        ];
    }

    private function getPillAsArray(Pill $pill): array
    {
        return [
            "id" => $pill->getId(),
            "text" => $pill->getText(),
            "authorId" => $pill->getAuthor()->getId(),
            "firstNameAuthor" => $pill->getAuthor()->getFirstName(),
            "lastNameAuthor" => $pill->getAuthor()->getLastName(),
            "createAt" => $pill->getCreateAt()->format(\DateTime::ATOM),
            "allowUpdate" => $this->userPermissions->hasUpdatePillPermission($pill),
            "allowDelete" => $this->userPermissions->hasDeletePillPermission($pill)
        ];
    }

    private function comparePillCreatedAt(Pill $a, Pill $b): int
    {
        if ($a->getCreateAt()->getTimestamp() == $b->getCreateAt()->getTimestamp()) {
            return 0;
        }
        return $a->getCreateAt()->getTimestamp() > $b->getCreateAt()->getTimestamp() ? -1 : 1;
    }

}