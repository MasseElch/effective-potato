<?php

namespace App\EventSubscriber;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JWTCreatedListener
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * @param EntityManagerInterface $em
     * @param NormalizerInterface $normalizer
     */
    public function __construct(EntityManagerInterface $em, NormalizerInterface $normalizer)
    {
        $this->em = $em;
        $this->normalizer = $normalizer;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $payload['username']]);

        $payload['user'] = $this->normalizer->normalize($user, 'json', ['groups' => ['user_token']]);

        $event->setData($payload);
    }
}