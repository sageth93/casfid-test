<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Command\UpdateNews\UpdateNewsCommand;
use App\Casfid\Feed\Infrastructure\API\Feed\Request\UpdateFeedRequest;
use App\Shared\Infrastructure\Controller\BaseController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class UpdateFeedController extends BaseController
{
    #[Route('/feeds/{id}', name: 'update_feed', methods: ['PUT'])]
    #[OA\Response(
        response: 204,
        description: 'News Updated',
    )]
    #[OA\Response(
        response: 304,
        description: 'Resource Not Modified',
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad Request',
    )]
    #[OA\Response(
        response: 404,
        description: 'News Not Found',
    )]
    #[OA\Response(
        response: 422,
        description: 'Validation Error',
    )]
    public function __invoke(
        string $id,
        #[MapRequestPayload] UpdateFeedRequest $request
    ): JsonResponse
    {
        $this->handle(
            new UpdateNewsCommand(
                id: $id,
                title: $request->title,
                content: $request->content,
                author: $request->author,
                date: $request->date
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
