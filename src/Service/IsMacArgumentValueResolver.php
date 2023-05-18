<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class IsMacArgumentValueResolver implements ArgumentValueResolverInterface
{
    /**
     * La condition pour identifier l'argument
     * Utilisé dans ArticleController->article_show
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        # $request->attributes->has('_isMac') -> returns false for a subrequest
        return $argument->getName() === 'isMac' && $request->attributes->has('_isMac');
    }

    /**
     * Returns a boolean = is Mac or Not
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $request->attributes->get('_isMac');
        ## if ($request->query->has('macos')) {
        ##     yield $request->query->getBoolean('mac');
        ##     return;
        ## }

        ## $userAgent = $request->headers->get('User-Agent');
        ## # Attention ! Must use yield, Resolve returns a Traversable
        ## yield strpos($userAgent, 'Mac') === true;
    }

}