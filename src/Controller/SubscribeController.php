<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\SubscriberRequest;
use App\Service\SubscriberService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    public function __construct(private readonly SubscriberService $subscriberService)
    {
    }

    #[OA\Response(
        response: 200,
        description: 'Subscribe email to newsletter mailing list ',
  //      content: new Model(type: Model::class)
    )]
    #[OA\Post(requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: SubscriberRequest::class))))]
    #[Route(path: 'api/v1/subscribe', methods: ['POST'])]
    public function action(#[RequestBody] SubscriberRequest $subscriberRequest): Response
    {
        $this->subscriberService->subscribe($subscriberRequest);

        return $this->json(null);
    }
}
