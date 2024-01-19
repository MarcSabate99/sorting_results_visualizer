<?php


namespace App\Infrastructure\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SortingVisualizerController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->render('sorting.html.twig');
    }
}