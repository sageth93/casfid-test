<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Command\AddNews\AddNewsCommand;
use App\Casfid\Feed\Infrastructure\API\Feed\Request\AddFeedRequest;
use App\Shared\Infrastructure\Controller\BaseController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class AddFeedController extends BaseController
{
    #[Route('/feeds/', name: 'add_feed', methods: ['POST'])]
    #[OA\Response(
        response: 204,
        description: 'News Created',
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad Request',
    )]
    #[OA\Response(
        response: 409,
        description: 'News already exists',
    )]
    #[OA\Response(
        response: 422,
        description: 'Validation Error',
    )]
    public function __invoke(
        #[MapRequestPayload] AddFeedRequest $request
    ): JsonResponse
    {
        $this->handle(
            new AddNewsCommand(
                id: $request->id,
                title: $request->title,
                content: $request->content,
                author: $request->author,
                date: $request->date
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
