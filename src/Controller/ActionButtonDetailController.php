<?php declare(strict_types=1);

namespace Segge\AppServer\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route(path: '/action-button/detail', name: 'segge.action-button.detail')]
class ActionButtonDetailController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
    )
    {   
    }

    #[Route(
        path: '/{entity}',
        name: '.entity',
        methods: [Request::METHOD_POST]
    )]
    public function createEntity(Request $request, string $entity): Response
    {
        // Get the JSON content from the request
        $content = $request->getContent();

        // Decode the JSON data
        $data = json_decode($content, true);

        // TODO: do something with the entity

        $this->debugRoute($entity, $data['data']);

        $response = new Response();
        return $response;
    }

    private function debugRoute(string $entity, mixed $data): void
    {
        $this->logger->debug(\sprintf('ActionButtonDetail Entity: "%s"', $entity), [
            'data' => $data,
        ]);
    }
}
