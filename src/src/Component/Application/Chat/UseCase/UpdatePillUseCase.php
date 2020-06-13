<?php


namespace LetEmTalk\Component\Application\Chat\UseCase;

use LetEmTalk\Component\Application\Chat\Request\UpdatePillRequest;
use LetEmTalk\Component\Domain\Authorization\Service\UserAuthorization;
use LetEmTalk\Component\Domain\Authorization\Service\UserPermissions;
use LetEmTalk\Component\Domain\Chat\Repository\PillRepository;
use LetEmTalk\Component\Domain\User\Repository\UserRepository;

class UpdatePillUseCase
{
    private PillRepository $pillRepository;
    private UserAuthorization $userAuthorization;

    public function __construct(PillRepository $pillRepository, UserAuthorization $userAuthorization)
    {
        $this->pillRepository = $pillRepository;
        $this->userAuthorization = $userAuthorization;
    }

    public function execute(UpdatePillRequest $request): void
    {
        $userPermissions = new UserPermissions($this->userAuthorization, $request->getUserId());

        $pill = $this->pillRepository->getPill($request->getPillId());

        if (!$userPermissions->allowUpdatePill($pill)) {
            throw new \InvalidArgumentException();
        }

        $pill->setText($request->getText());
        $this->pillRepository->save($pill);
    }
}