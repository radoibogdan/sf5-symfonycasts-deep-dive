<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleController extends AbstractController
{
    /**
     * Currently unused: just showing a controller with a constructor!
     */
    private $isDebug;
    private LoggerInterface $logger;

    public function __construct(bool $isDebug, LoggerInterface $logger)
    {
        $this->isDebug = $isDebug;
        $this->logger = $logger;

        $this->logger->info('Constructor: Controller instantiated');
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository, LoggerInterface $logger)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        $logger->info('Inside controller');

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show", defaults={"foo": "bar"})
     */
    public function show($slug, SlackClient $slack, ArticleRepository $articleRepository, $isMac, $isMacos)
    {
        # dump argument added in Event Listener UserAgentSubscriber
        dump($isMac);

        # dump argument resolved from Service/IsMacArgumentValueResolver
        dump($isMacos);

        $article = $articleRepository->findOneBy(['slug' => $slug]);
        if (!$article) {
            throw $this->createNotFoundException();
        }
        if ($article->getSlug() === 'khaaaaaan') {
            $slack->sendMessage('Kahn', 'Ah, Kirk, my old friend...');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        $logger->info('Article is being hearted!');

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
