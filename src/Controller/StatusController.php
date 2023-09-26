<?php

declare(strict_types=1);

namespace Tahicz\SymfonyStatusLoggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Tahicz\SymfonyStatusLoggerBundle\StatusExport\StatusExport;

class StatusController extends AbstractController
{
    #[Route('api/status', name: 'api_status', methods: ['GET'])]
    public function status(StatusExport $statusExport): JsonResponse
    {
        return new JsonResponse($statusExport->asArray()->toArray());
    }
}
