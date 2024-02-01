<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\SortingUrlGeneratorCommand;
use App\Application\Service\SortingUrlGenerator;
use App\Infrastructure\Service\RequestValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GenerateSortingUrlVisualizerController extends AbstractController
{
    private const REQUIRED_FIELDS = [
        'elements',
    ];
    private const REQUIRED_INTERNAL_FIELDS = [
        'title',
        'imageUrl',
    ];

    public function __construct(
        private readonly SortingUrlGenerator $sortingUrlGenerator,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly RequestValidation $requestValidation
    ) {
    }

    #[Route('/generate/visualizer', name: 'generate_visualizer', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $this->requestValidation->validateInternalFields(
                $request,
                self::REQUIRED_FIELDS,
            self::REQUIRED_INTERNAL_FIELDS
            );

            $body = json_decode($request->getContent(), true);
            $sortingShareUrl = $this->sortingUrlGenerator->handle(
                new SortingUrlGeneratorCommand(
                    $body['elements'],
                    $this->urlGenerator->generate('index', [], UrlGeneratorInterface::ABSOLUTE_URL)
                )
            );

            return $this->json([
                'sortingShareUrl' => $sortingShareUrl,
            ]);
        } catch (\Throwable $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
