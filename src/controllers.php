<?php
/**
 * @var $app \Silex\Application
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return null;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});




/**
 * Вывод статей для указанной страницы
 */
$app->get('/page/{pageId}/', function (int $pageId) use ($app) {
    /** @var \Service\Recommender\RecommenderService $recommender */
    $recommender = $app['recommender'];
    $limit = 12;
    $offset = ($pageId - 1) * $limit;
    $recommender->setLimit($limit);
    $recommender->setOffset($offset);
    $documentsIdsArr = $recommender->getDocumentsIds();
    $offersEntityArr = $app['offers.repository']->findBy([
        'id' => $documentsIdsArr,
        //'status' => 'p',
    ]);
    if (empty($offersEntityArr)) {
        return json_encode([
            'count' => 0,
            'items' => [],
        ]);
    }
    /** @var \AppBundle\Entity\OfferEntity $offerEntity */
    $offersArr = [];
    foreach ($offersEntityArr as $offerEntity) {
        $offersArr[] = $app['twig']->render('article-mini.html', [
            'atricle_id' => $offerEntity->getId(),
            'atricle_title' => $offerEntity->getTitle(),
            'atricle_image_url' => '',
            'atricle_url' => '',
        ]);
    }
    return json_encode([
        'count' => count($offersEntityArr),
        'items' => $offersArr,
    ]);
});