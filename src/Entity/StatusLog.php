<?php

declare(strict_types=1);

namespace Tahicz\SymfonyStatusLoggerBundle\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;
use Tahicz\SymfonyStatusLoggerBundle\Repository\StatusLogRepository;

#[ORM\Entity(repositoryClass: StatusLogRepository::class)]
class StatusLog
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private ?Ulid $id = null;

    #[ORM\Column(length: 255)]
    private string $jobName;

    /**
     * @var array<int|string, mixed>
     */
    #[ORM\Column(nullable: true)]
    private array $context = [];

    #[ORM\Column(nullable: true)]
    private ?int $exitCode = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $start;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $stop = null;

    #[ORM\Column(nullable: true)]
    private ?int $status = null;

    /**
     * @param array<int|string, mixed> $context
     */
    public function __construct(string $jobName, array $context)
    {
        $this->jobName = $jobName;
        $this->context = $context;
        $this->start = new DateTimeImmutable();
        $this->id = new Ulid();
    }

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getJobName(): string
    {
        return $this->jobName;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }

    public function addContext(mixed $context, ?string $key = null): void
    {
        if (empty($key)) {
            $this->context[] = $context;
        } else {
            $this->context[$key] = $context;
        }
    }

    public function getExitCode(): ?int
    {
        return $this->exitCode;
    }

    public function getStart(): DateTimeInterface
    {
        return $this->start;
    }

    public function getStop(): ?DateTimeInterface
    {
        return $this->stop;
    }

    public function jobStop(int $exitCode, int $status): void
    {
        $this->stop = new DateTimeImmutable();
        $this->exitCode = $exitCode;
        $this->setStatus($status);
    }

    public function increaseStatus(int $step): void
    {
        if (null === $this->status) {
            $this->status = 0;
        }
        $this->status += $step;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
