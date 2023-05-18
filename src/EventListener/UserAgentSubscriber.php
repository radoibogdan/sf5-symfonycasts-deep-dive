<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        // Si c'est une subrequest ne rien faire
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        # Add response to Request Event stopping the Flow in HttpKernel.php -> handleRaw()
        # $event->setResponse(new Response('Stop flow'));

        # Change Controller & stop tout le procès
        # $request->attributes->set('_controller', function ($slug = null) {
        #     # We have access to the $slug wildcard argument in the "ArticleController->article_show" route
        #     dump($slug);
        #     return new Response('I just took over the controller');
        # });

        # Log Data
        $this->logger->info('Log data before controller');

        # use event typed as the one return by getSubscribedEvents
        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info(sprintf('User Agent is %s', $userAgent));

        # Rajoute un attribut, (dumped in ArticleController->article_show)
        $isMac = strpos($userAgent, 'Mac') === true;
        $request->attributes->set('isMac', $isMac);
        $request->attributes->set('_isMac', $this->isMac($request));
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

    private function isMac(Request $request)
    {
        if ($request->query->has('macos')) {
            return $request->query->getBoolean('macos');
        }

        $userAgent = $request->headers->get('User-Agent');
        return strpos($userAgent, 'Mac') === true;
    }
}