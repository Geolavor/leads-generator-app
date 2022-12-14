<?php

declare(strict_types=1);

namespace App\Contracts;

interface BanService
{
    /**
     * Ban entity.
     *
     * @param \App\Contracts\Bannable $bannable
     * @param array $attributes
     * @return \App\Contracts\Ban
     */
    public function ban(Bannable $bannable, array $attributes = []): Ban;

    /**
     * Unban entity.
     *
     * @param \App\Contracts\Bannable $bannable
     * @return void
     */
    public function unban(Bannable $bannable): void;

    /**
     * Delete all expired Ban models.
     *
     * @return void
     */
    public function deleteExpiredBans(): void;
}