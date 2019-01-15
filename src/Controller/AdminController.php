<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\NewsletterType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin/newsletter/send", name="newsletter_send")
     *
     * @param Request        $request
     * @param UserRepository $userRepository
     * @param \Swift_Mailer  $mailer
     *
     * @return Response
     */
    public function sendNewsletterAction(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(NewsletterType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $emailsArray = $userRepository->getSubscribedUsers();
            $message = (new \Swift_Message('IZINT: Newsletter'))
                ->setFrom('i.ovidiuenache@gmail.com')
                ->setTo(array_column($emailsArray,'email'))
                ->setBody($form->get('message')->getData());

            $mailer->send($message);

            return $this->render('pages/newsletter/send_newsletter.html.twig');
        }

        return $this->render('pages/newsletter/send_newsletter.html.twig', ['form' => $form->createView()]);
    }
}
