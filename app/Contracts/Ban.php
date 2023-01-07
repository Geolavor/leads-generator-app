<?php

declare(strict_types=1);

namespace App\Contracts;

interface Ban
{
    /**
     * Determine if Ban is permanent.
     *
     * @return bool
     */
    public function isPermanent(): bool;

    /**
     * Determine if Ban is temporary.
     *
     * @return bool
     */
    public function isTemporary(): bool;
}