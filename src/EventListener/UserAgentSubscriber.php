<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserAgentSubscriber implements EventSubscriberInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->logger->info('Log data before controller');

        # use event typed as the one return by getSubscribedEvents
        $userAgent = $event->getRequest()->headers->get('User-Agent');
        $this->logger->info(sprintf('User Agent is %s', $userAgent));
    }

    /**
     * Listen to event Request Event (kernel.request),
     * When it happens execute method that we created onKernelRequest
     *
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            # pass the event class name. RequestEvent = kernel.request
            RequestEvent::class => 'onKernelRequest'
        ];
    }

}