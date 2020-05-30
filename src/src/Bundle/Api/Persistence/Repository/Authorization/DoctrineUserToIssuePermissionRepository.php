<?php


namespace LetEmTalk\Bundle\Api\Persistence\Repository\Authorization;


use Doctrine\ORM\EntityRepository;
use LetEmTalk\Component\Domain\Authorization\Entity\UserToIssuePermission;
use LetEmTalk\Component\Domain\Authorization\Repository\UserToIssuePermissionRepository;

class DoctrineUserToIssuePermissionRepository extends EntityRepository implements UserToIssuePermissionRepository
{

    public function save(UserToIssuePermission $userToIssuePermission): void
    {
        $this->getEntityManager()->persist($userToIssuePermission);
        $this->getEntityManager()->flush();
    }
}