<?php


namespace LetEmTalk\Bundle\Api\Persistence\Repository\Chat;


use LetEmTalk\Bundle\Api\Persistence\Repository\RedisKey;
use LetEmTalk\Bundle\Api\Persistence\Repository\RedisRepository;
use LetEmTalk\Component\Domain\Chat\Entity\Issue;
use LetEmTalk\Component\Domain\Chat\Entity\Pill;
use LetEmTalk\Component\Domain\Chat\Repository\PillRepository;

class RedisInvalidatePillRepository extends RedisRepository implements PillRepository
{
    const KEY_PILL_NAME = array("pill");
    const KEY_PILL_BY_ISSUE_NAME = array("pillsIssue");

    private PillRepository $pillRepository;

    public function __construct(PillRepository $pillRepository)
    {
        parent::__construct();
        $this->pillRepository = $pillRepository;
    }

    public function save(Pill $pill): void
    {
        $this->pillRepository->save($pill);
        $this->del(new RedisKey(self::KEY_PILL_NAME, array($pill->getId())));
        $this->del(new RedisKey(self::KEY_PILL_BY_ISSUE_NAME, array($pill->getIssue()->getId())));
    }

    public function getPill(int $pillId): Pill
    {
        return $this->pillRepository->getPill($pillId);
    }

    public function getPillsByIssue(Issue $issue): array
    {
        return $this->pillRepository->getPillsByIssue($issue);
    }

    public function delete(int $pillId): void
    {
        $pill = $this->pillRepository->getPill($pillId);
        $this->del(new RedisKey(self::KEY_PILL_NAME, array($pillId)));
        $this->del(new RedisKey(self::KEY_PILL_BY_ISSUE_NAME, array($pill->getIssue()->getId())));
        $this->pillRepository->delete($pillId);
    }
}