<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->redirectToRoute('fos_user_security_login');
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
