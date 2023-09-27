<?php

declare(strict_types=1);

namespace Tahicz\SymfonyStatusLoggerBundle\StatusExport;

use Doctrine\Common\Collections\ArrayCollection;
use Tahicz\SymfonyStatusLoggerBundle\Repository\StatusLogRepository;
use Tahicz\SymfonyStatusLoggerBundle\StatusExport\Model\ServiceStatus;

class StatusExport
{
    /** @var \Doctrine\Common\Collections\ArrayCollection<int, ServiceStatus> */
    private ArrayCollection $statusCollection;

    public function __construct(private readonly StatusLogRepository $statusLogRepository)
    {
        $this->statusCollection = new ArrayCollection();
		$this->statusCollection->add(['requestTime'=>time()]);
    }

    public function addStatus(ServiceStatus $export): void
    {
        $this->statusLogRepository->latest();
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection<int, ServiceStatus>
     */
    public function asArray(): ArrayCollection
    {
        $this->loadStatusesForCommandJobs();

        return $this->statusCollection;
    }

    public function loadStatusesForCommandJobs(): void
    {
        foreach ($this->statusLogRepository->latest() as $cornJobs) {
            $this->statusCollection->add(
                new ServiceStatus(
                    $cornJobs->getJobName(),
                    $cornJobs->getStop(),
                    $cornJobs->getStatus()
                )
            );
        }
    }
}
