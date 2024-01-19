<?php

namespace App\Infrastructure\Controller;

use App\Application\Command\Sorting\SortingUrlGeneratorCommand;
use App\Application\Command\Sorting\SortingVisualizerCommand;
use App\Application\Service\Sorting\SortingUrlGenerator;
use App\Application\Service\Sorting\SortingVisualizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;

class GenerateSortingVisualizerController extends AbstractController
{

    public function __construct(
        private SortingVisualizer $sortingVisualizer,
        private SortingUrlGenerator $sortingUrlGenerator,
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    #[Route('/generate/visualizer', name: 'generate_visualizer')]
    public function index(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        if(null === $file) {
            return $this->json([
                'message' => "No file provided"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        try {
            $data = $this->sortingVisualizer->handle(
                new SortingVisualizerCommand(
                    $file
                )
            );

            $sortingShareUrl = $this->sortingUrlGenerator->handle(
                new SortingUrlGeneratorCommand(
                    $data,
                    $this->urlGenerator->generate('index', [], UrlGeneratorInterface::ABSOLUTE_URL)
                )
            );

            return $this->json([
                'data' => $data,
                'sortingShareUrl' => $sortingShareUrl
            ]);
        } catch (Throwable $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
