<?php


namespace LetEmTalk\Component\Domain\Authorization\Repository;


use LetEmTalk\Component\Domain\Authorization\Entity\UserToIssuePermission;

interface UserToIssuePermissionRepository
{
    public function save(UserToIssuePermission $userToIssuePermission): void;

    public function delete(int $userId, int $issueId): void;
}