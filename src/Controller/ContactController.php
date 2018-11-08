<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
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
        $messageSent = null;
        $form = $this->createForm(ContactType::class, null, ['user' => $this->getUser()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $message = (new \Swift_Message('IZINT: New Contact Message'))
                ->setFrom($formData['email'])
                ->setTo('i.ovidiuenache@gmail.com')
                ->setBody(
                    'You have received a new contact message from ' . $formData['lastName'] . ' ' .
                        $formData['firstName'] . PHP_EOL .
                    'Email: ' . $formData['email'] . PHP_EOL . PHP_EOL .
                    'Message:' . PHP_EOL . PHP_EOL . $formData['message']
                );

            $messageSent = $this->get('mailer')->send($message) === 1;
        }

        return $this->render(
            'pages/contact.html.twig',
            ['form' => $form->createView(), 'successfullySent' => $messageSent]
        );
    }
}
