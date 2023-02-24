<?php

namespace App\Tests\ArgumentResolver;

use App\ArgumentResolver\RequestBodyArgumentResolver;
use App\Attribute\RequestBody;
use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use App\Tests\AbstractTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestBodyArgumentResolverTest extends AbstractTestCase
{
    private readonly SerializerInterface $serializer;
    private readonly ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
    }

    public function testResolveArgumentIsNotInstanceOf(): void
    {
        $meta = new ArgumentMetadata(
            name: 'some',
            type: null,
            isVariadic: false,
            hasDefaultValue: false,
            defaultValue: false,
        );

        $this->assertEquals([], iterator_to_array($this->createResolver()->resolve(new Request(), $meta)));
    }

    public function testResolveThrowsWhenDeserialize(): void
    {
        $this->expectException(RequestBodyConvertException::class);

        $request = new Request(content: 'testing content');
        $meta = new ArgumentMetadata(
            name: 'some',
            type: \stdClass::class,
            isVariadic: false,
            hasDefaultValue: false,
            defaultValue: false,
            attributes: [new RequestBody()],
        );

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with('testing content', \stdClass::class, JsonEncoder::FORMAT)
            ->willThrowException(new \Exception());

        $this->createResolver()->resolve($request, $meta)->next();
    }

    public function testResolveThrowsWhenValidationFailed(): void
    {
        $this->expectException(ValidationException::class);

        $body = ['test' => true];
        $encodedBody = json_encode($body);

        $request = new Request(content: $encodedBody);
        $meta = new ArgumentMetadata(
            name: 'some',
            type: \stdClass::class,
            isVariadic: false,
            hasDefaultValue: false,
            defaultValue: null,
            attributes: [new RequestBody()],
        );

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with($encodedBody, \stdClass::class, JsonEncoder::FORMAT)
            ->willReturn($body);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($body)
            ->willReturn(new ConstraintViolationList([
                new ConstraintViolation('error', null, [], null, 'some', null),
            ]));

        $this->createResolver()->resolve($request, $meta)->next();
    }

    public function testResolve(): void
    {
        $body = ['test' => true];
        $encodedBody = json_encode($body);

        $request = new Request(content: $encodedBody);
        $meta = new ArgumentMetadata(
            name: 'some',
            type: \stdClass::class,
            isVariadic: false,
            hasDefaultValue: false,
            defaultValue: null,
            attributes: [new RequestBody()],
        );

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with($encodedBody, \stdClass::class, JsonEncoder::FORMAT)
            ->willReturn($body);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($body)
            ->willReturn(new ConstraintViolationList([]));

        $actual = $this->createResolver()->resolve($request, $meta);

        $this->assertEquals($body, $actual->current());
    }

    private function createResolver(): RequestBodyArgumentResolver
    {
        return new RequestBodyArgumentResolver($this->serializer, $this->validator);
    }
}
