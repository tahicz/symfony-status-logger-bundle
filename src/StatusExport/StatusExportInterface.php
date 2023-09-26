<?php

declare(strict_types=1);

namespace Tahicz\SymfonyStatusLoggerBundle\StatusExport;

interface StatusExportInterface
{
    public function getProcessedCount(): int;
}
