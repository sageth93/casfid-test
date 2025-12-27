<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Command\DeleteNewsById\DeleteNewsByIdCommand;
use App\Shared\Infrastructure\Controller\BaseController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class DeleteFeedController extends BaseController
{
    #[Route('/feeds/{id}', name: 'delete_feed', methods: ['DELETE'])]
    #[OA\Response(
        response: 204,
        description: 'Deleted News',
    )]
    #[OA\Response(
        response: 404,
        description: 'News Not Found'
    )]
    public function __invoke(
        string $id
    ): JsonResponse
    {
        $this->handle(
            new DeleteNewsByIdCommand($id)
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
