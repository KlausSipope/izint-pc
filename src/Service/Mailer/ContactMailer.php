<?php declare(strict_types=1);

namespace App\Service\Mailer;

use BookingBundle\Exception\Entity\MissingMandatoryFieldException;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class ContactMailer implements MailerInterface
{
    /**
     * @var array
     */
    private const MANDATORY_DATA_FIELDS = ['email', 'firstName', 'lastName', 'message'];

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * Target email that will receive the emails sent by users
     *
     * @var string
     */
    protected $receiver;

    /**
     * @var string
     */
    protected $mailTitle;

    /**
     * @var string
     */
    protected $mailBody;

    /**
     * @param \Swift_Mailer $mailer
     * @param string        $receiver
     * @param string        $mailBody
     * @param string        $mailTitle
     */
    public function __construct(\Swift_Mailer $mailer, string $receiver, string $mailBody, string $mailTitle)
    {
        $this->mailer    = $mailer;
        $this->receiver  = $receiver;
        $this->mailBody  = $mailBody;
        $this->mailTitle = $mailTitle;
    }

    /**
     * @inheritdoc
     */
    public function send(array $data): int
    {
        $this->validate($data);

        $message = (new \Swift_Message($this->mailTitle))
            ->setFrom($data['email'])
            ->setTo($this->receiver)
            ->setBody(sprintf($this->mailBody, $data['firstName'], $data['lastName'], $data['email'], $data['message']));

        return $this->mailer->send($message);
    }

    /**
     * @param array $data
     *
     * @throws MissingMandatoryFieldException
     */
    protected function validate(array $data)
    {
        foreach (self::MANDATORY_DATA_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new MissingMandatoryFieldException($field);
            }
        }
    }
}
