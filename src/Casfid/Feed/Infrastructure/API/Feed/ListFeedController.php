<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Query\ListNews\ListNewsQuery;
use App\Casfid\Feed\Application\News\Response\NewsResponse;
use App\Shared\Infrastructure\Controller\BaseController;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class ListFeedController extends BaseController
{
    #[Route('/feeds/', name: 'list_feed', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return all News',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(type: NewsResponse::class),
                type: 'object'
            )
        )
    )]
    public function __invoke(): JsonResponse
    {
        $response = $this->handle(
            new ListNewsQuery()
        );

        return new JsonResponse($response);
    }
}
