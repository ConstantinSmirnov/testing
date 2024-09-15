<?php

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Services\UlidService;

class User
{
    private string $ulid;
    private string $name;

    public function __construct(string $name)
    {
        $this->ulid = UlidService::generate();
        $this->name = $name;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}