<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Service\Mailer\ContactMailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class ContactController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request): Response
    {
        $form = $this->createForm(ContactType::class, null, ['user' => $this->getUser()]);
        $form->handleRequest($request);

        $successfullySent = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $successfullySent = 1 === $this->get(ContactMailer::class)->send($form->getData());
        }

        return $this->render(
            'pages/contact.html.twig',
            ['form' => $form->createView(), 'successfullySent' => $successfullySent]
        );
    }
}
