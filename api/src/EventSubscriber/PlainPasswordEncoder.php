<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PlainPasswordEncoder
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->execute($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->execute($args);
    }

    private function execute(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        // only act on User entity
        if ($entity instanceof User && $entity->getPlainPassword()) {
            $entity->setPassword($this->encoder->encodePassword($entity, $entity->getPlainPassword()));
        }
    }
}