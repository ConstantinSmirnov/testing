<?php

namespace App\Users\Aplication\DTO;

use App\Users\Domain\Entity\User;
use JetBrains\PhpStorm\Pure;

class UserDTO
{
    public function __construct(public readonly string $ulid, public readonly string $name)
    {
    }

    #[Pure]
    public static function fromEntity(User $user): self
    {
        return new self($user->getUlid(), $user->getName());
    }
}