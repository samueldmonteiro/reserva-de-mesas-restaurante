<?php

namespace App\ValueObject;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
        }

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function equals(Email $email): bool
    {
        return $this->email === $email->getEmail();
    }
}
