<?php

declare(strict_types=1);

namespace Tahicz\SymfonyStatusLoggerBundle\StatusExport\Model;

use DateTimeInterface;
use JsonSerializable;

readonly class ServiceStatus implements JsonSerializable
{
    public function __construct(private string $serviceName, private ?DateTimeInterface $lastUpdate, private ?int $healthPercentage, private ?string $msg = null)
    {
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getLastUpdate(): ?DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function getHealthPercentage(): int
    {
        if (null === $this->healthPercentage) {
            return 0;
        }

        return $this->healthPercentage;
    }

    /**
     * @return array<string,null|DateTimeInterface|int|string>
     */
    public function jsonSerialize(): array
    {
        return [
            'serviceName' => $this->getServiceName(),
            'lastUpdate' => $this->getLastUpdate(),
            'health' => $this->getHealthPercentage(),
            'msg' => $this->getMsg(),
        ];
    }
}
