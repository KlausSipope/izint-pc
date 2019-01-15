<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Service\Mailer\ContactMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class ContactController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/contact", name="contact")
     *
     * @throws \App\Exception\MissingMandatoryFieldException
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
