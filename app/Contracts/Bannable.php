<?php

declare(strict_types=1);

namespace App\Contracts;

interface Bannable
{
    /**
     * Ban model.
     *
     * @param null|array $attributes
     * @return \App\Contracts\Ban
     */
    public function ban(array $attributes = []): Ban;

    /**
     * Remove ban from model.
     *
     * @return void
     */
    public function unban(): void;

    /**
     * If model is banned.
     *
     * @return bool
     */
    public function isBanned(): bool;

    /**
     * If model is not banned.
     *
     * @return bool
     */
    public function isNotBanned(): bool;
}