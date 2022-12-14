<?php

namespace App\Contracts;

interface ExportInterface
{
    public function toString();

    public function download();
}