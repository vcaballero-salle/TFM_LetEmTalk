<?php


namespace LetEmTalk\Component\Domain\Chat\Entity;


use LetEmTalk\Component\Domain\User\Entity\User;

class Pill
{
    private int $id;
    private Issue $issue;
    private string $text;
    private User $author;
    private \DateTime $created;
}