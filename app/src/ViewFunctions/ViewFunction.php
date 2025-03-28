<?php

declare(strict_types=1);

namespace App\ViewFunctions;

abstract class ViewFunction
{
    /** @var string The function name */
    protected string $name = '';

    /** Get the function name. */
    public function name(): string
    {
        return $this->name;
    }
}
