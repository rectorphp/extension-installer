<?php

declare(strict_types=1);

use Nette\Security\Passwords;

final class SomeNetteClass
{
    public function run()
    {
        Passwords::hash('value');
    }
}
