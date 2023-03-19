<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Domain\UseCase\GenerateGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game.json', name: 'game_generate')]
class GenerateGameController extends AbstractController
{
    public function __invoke(Request $request, GenerateGame $generateGame): JsonResponse
    {
        $game = $generateGame->execute();
        $request->getSession()->set('game', json_encode($game));

        return $this->json($game);
    }
}
