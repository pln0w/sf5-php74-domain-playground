<?php

declare(strict_types=1);

namespace User\Application\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\GenericEvent;
use User\Domain\Model\UserInterface;
use User\Domain\Security\PasswordUpdaterInterface;

class PasswordUpdaterListener
{
    private PasswordUpdaterInterface $passwordUpdater;

    public function __construct(PasswordUpdaterInterface $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }

    public function genericEventUpdater(GenericEvent $event): void
    {
        $this->updatePassword($event->getSubject());
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $user = $event->getObject();

        if (!$user instanceof UserInterface) {
            return;
        }

        $this->updatePassword($user);
    }

    public function preUpdate(LifecycleEventArgs $event): void
    {
        $user = $event->getObject();

        if (!$user instanceof UserInterface) {
            return;
        }

        $this->updatePassword($user);
    }

    protected function updatePassword(UserInterface $user): void
    {
        if (null !== $user->getPlainPassword()) {
            $this->passwordUpdater->updatePassword($user);
        }
    }
}
