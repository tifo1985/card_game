<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Domain\Request\SortCardsRequest;
use App\Domain\UseCase\SortCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sort_cards.json', name: 'sort_cards')]
class SortCardsController extends AbstractController
{
    public function __invoke(Request $request, SortCards $sortCards): JsonResponse
    {
        try {
            $gameData = \json_decode($request->getSession()->get('game', '[]'), true, 512, JSON_THROW_ON_ERROR);
            $game = $sortCards->execute(new SortCardsRequest($gameData));

            return $this->json($game);
        } catch (\Throwable $exception) {
            return new JsonResponse([
                'error' => 'Game not found',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
