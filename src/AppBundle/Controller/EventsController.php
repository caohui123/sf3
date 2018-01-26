<?php

namespace AppBundle\Controller;

use Monolog\Logger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EventsController
 * @package AppBundle\Controller
 * @Route("/events")
 */
class EventsController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->find(14);
        $event = new GenericEvent($user);

        $eventDispatcher->addListener('commented.create', function (GenericEvent $event) {
            // will be executed when the foo.action event is dispatched
            // （此处的代码）将在foo.action事件被派遣之后执行

            $user = $event->getSubject();
            $logger = $this->get('logger');
            $logger->info('I just got the logger');
            $logger->info("action事件被派遣之后执行".$user->getName());
        });

        $eventDispatcher->dispatch('commented.create', $event);

        return new Response('sdfsdf');
    }

}
