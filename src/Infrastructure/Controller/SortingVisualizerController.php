<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\SortingGetterCommand;
use App\Application\Service\SortingGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SortingVisualizerController extends AbstractController
{
    public function __construct(
        private readonly SortingGetter $sortingGetter
    ) {
    }

    #[Route('/{id}', name: 'index', defaults: ['id' => null])]
    public function index(?string $id): Response
    {
        $elements = [
            'elements' => json_encode(
                []
            ),
        ];
        try {
            if (null !== $id) {
                $elements = $this->sortingGetter->handle(
                    new SortingGetterCommand($id)
                );
            }
        } catch (\Throwable $exception) {}


        return $this->render('sorting.html.twig', $elements);
    }
}
