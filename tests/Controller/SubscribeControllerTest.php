<?php

namespace App\Tests\Controller;

use App\Controller\SubscribeController;
use App\Tests\AbstractControllerTest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class SubscribeControllerTest extends AbstractControllerTest
{
    public function testSubscribe()
    {
        $content = json_encode(['email' => 'test@example.com', 'agreed' => true]);
        $this->client->request('POST', '/api/v1/subscribe', content: $content);

        $this->assertResponseIsSuccessful();
    }
    public function testSubscribeNotAgreed()
    {
        $content = json_encode(['email' => 'test@example.com']);
        $this->client->request('POST', '/api/v1/subscribe', content: $content);
        $responseContent = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJsonDocumentMatches($responseContent, [
            '$.message' => 'Validation failed',
            '$.details.violations' => self::countOf(1),
            '$.details.violations[0].field' => 'agreed',
        ]);
    }
}
