<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class StaticController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function homepageAction(): Response
    {
        return $this->render('pages/homepage.html.twig');
    }

    /**
     * @Route("/about", name="about")
     *
     * @return Response
     */
    public function aboutAction(): Response
    {
        return $this->render('pages/about.html.twig');
    }
}
