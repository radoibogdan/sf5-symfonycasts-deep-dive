<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PartialController extends AbstractController
{
    /**
     * Partial used in homepage.html.twig
     *
     * Partial : article/trending_quotes_partial.html.twig
     */
    public function trendingQuotes($isMac)
    {
        $quotes = $this->getTrendingQuotes();

        return $this->render('article/trending_quotes_partial.html.twig', [
            'quotes' => $quotes,
            'isMac' => $isMac
        ]);
    }

    /**
     * Simulate database get request
     */
    public function getTrendingQuotes()
    {
        return [
            [
                'author' => 'Wernher von Braun, Rocket Engineer',
                'link' => 'https://en.wikipedia.org/wiki/Wernher_von_Braun',
                'quote' => 'Our two greatest problems are gravity and paperwork. We can lick gravity, but sometimes the paperwork is overwhelming.',
            ],
            [
                'author' => 'Aaron Cohen, NASA Administrator',
                'link' => 'https://en.wikipedia.org/wiki/Aaron_Cohen_(Deputy_NASA_administrator)',
                'quote' => 'Let\'s face it, space is a risky business. I always considered every launch a barely controlled explosion.',
            ],
            [
                'author' => 'Christa McAuliffe, Challenger Astronaut',
                'link' => 'https://en.wikipedia.org/wiki/Christa_McAuliffe',
                'quote' => 'If offered a seat on a rocket ship, don\'t ask what seat. Just get on.',
            ],
        ];
    }
}