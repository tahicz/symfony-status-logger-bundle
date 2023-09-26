<?php

declare(strict_types=1);

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tahicz\SymfonyStatusLoggerBundle\Entity\StatusLog;
use Tahicz\SymfonyStatusLoggerBundle\Repository\StatusLogRepository;

abstract class StatusCommand extends Command
{
    public const CONTEXT_ERROR_MSG = 'err';

    protected int $status = 0;
	protected StatusLog $statusLog;

    public function __construct(private readonly StatusLogRepository $statusLogRepository, string $name = null)
    {
        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $this->preRun(['args' => $input->getArguments()]);
        $exitCode = parent::run($input, $output);
        $this->postRun($exitCode);

        return $exitCode;
    }

    public function increaseStatus(int $step): void
    {
        $this->status += $step;
    }

    public function addContext(string $key, mixed $data): void
    {
        $this->statusLog->addContext($data, $key);
    }

    /**
     * Status kvality jobu/ v % (0-100).
     */
    protected function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param array<int|string, mixed> $context
     */
    private function preRun(array $context): void
    {
        $name = $this->getName();
        if (null === $name) {
            $name = md5((string) time());
        }
        $this->statusLog = new StatusLog($name, $context);
        $this->statusLogRepository->save($this->statusLog, true);
    }

    private function postRun(int $exitCode): void
    {
        $this->statusLog->jobStop($exitCode, $this->getStatus());
        $this->statusLogRepository->save($this->statusLog, true);
    }

    private function getStatus(): int
    {
        if ($this->status < 0 | $this->status > 100) {
            throw new RuntimeException('');
        }

        return $this->status;
    }
}
