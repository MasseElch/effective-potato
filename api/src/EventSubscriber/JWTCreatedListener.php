<?php

namespace App\EventSubscriber;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class JWTCreatedListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
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

        $payload['user'] = $this->serializer->normalize($user, 'json', ['groups' => ['user_token']]);

        $event->setData($payload);
    }
}