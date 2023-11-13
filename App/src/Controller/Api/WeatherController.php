<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Factory\CreateWeatherMessageFactory;
use App\Factory\MessageFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weather', name: "weather_")]
class WeatherController extends AbstractController
{
    public function __construct(
        #[Autowire(service: CreateWeatherMessageFactory::class)]
        private MessageFactoryInterface $factory,
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Route(path: '/', name: 'create', methods: [Request::METHOD_POST])]
    public function create(Request $request): JsonResponse
    {
        $this->messageBus->dispatch($this->factory->createMessage($request->request->all()));

        return $this->json([], Response::HTTP_CREATED);
    }
}
