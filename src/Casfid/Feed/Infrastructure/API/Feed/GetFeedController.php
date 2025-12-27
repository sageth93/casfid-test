<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Query\FindNewsById\FindNewsByIdQuery;
use App\Casfid\Feed\Application\News\Response\NewsResponse;
use App\Shared\Infrastructure\Controller\BaseController;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class GetFeedController extends BaseController
{
    #[Route('/feeds/{id}', name: 'get_feed', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'News for the given Id',
        content: new OA\JsonContent(
            ref: new Model(type: NewsResponse::class)
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'News Not Found'
    )]
    public function __invoke(
        string $id
    ): JsonResponse
    {
        $response = $this->handle(
            new FindNewsByIdQuery($id)
        );
        return new JsonResponse($response);
    }
}
