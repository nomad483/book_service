<?php

namespace App\Service;

use App\Entity\Subscriber;
use App\Exception\SubscriberAlreadyExistsException;
use App\Interface\Service\SubscriberServiceInterface;
use App\Model\SubscriberRequest;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class SubscriberService implements SubscriberServiceInterface
{
    public function __construct(
        private SubscriberRepository $subscriberRepository,
        private EntityManagerInterface $em,
    ) {
    }

    public function subscribe(SubscriberRequest $request): void
    {
        if ($this->subscriberRepository->existsByEmail($request->getEmail())) {
            throw new SubscriberAlreadyExistsException();
        }

        $subscriber = new Subscriber();
        $subscriber->setEmail($request->getEmail());

        $this->em->persist($subscriber);
        $this->em->flush();
    }
}
