<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Notifies post's author about new comments.
 *
 * @author Oleg Voronkovich <oleg-voronkovich@yandex.ru>
 */
class CommentNotificationSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'commented.create' => 'onCommentCreated',
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onCommentCreated(GenericEvent $event)
    {
        /** @var User $user */
        $user = $event->getSubject();
        echo $user->getName();
    }
}
