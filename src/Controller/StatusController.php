<?php

declare(strict_types=1);

namespace Tahicz\SymfonyStatusLoggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tahicz\SymfonyStatusLoggerBundle\StatusExport\StatusExport;

class StatusController extends AbstractController
{
	public function index(StatusExport $statusExport): JsonResponse
	{
		return new JsonResponse($statusExport->asArray()->toArray());
	}
}
