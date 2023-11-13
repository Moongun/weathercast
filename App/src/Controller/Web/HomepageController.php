<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Factory\BuildLocationMessageFactory;
use App\Factory\MessageFactoryInterface;
use App\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        #[Autowire(service: BuildLocationMessageFactory::class)]
        private MessageFactoryInterface $messageFactory,
    ) {
    }

    #[Route(path: '/', name: 'homepage', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request): Response
    {
        $location  = null;

        $form = $this->createForm(LocationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $location = $this->handle($this->messageFactory->createMessage($data));
        }

        return $this->render('homepage/index.html.twig', [
            'form' => $form,
            'temperature' => $location?->getWeather()?->getTemperature(),
        ]);
    }
}
