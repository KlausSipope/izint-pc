<?php declare(strict_types=1);

namespace App\Service\Mailer;

use BookingBundle\Exception\Entity\MissingMandatoryFieldException;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
interface MailerInterface
{
    /**
     * @param array $data the data contained in the email body
     *
     * @return int the number of successful sent emails. Can be 0 which means the send failed
     *
     * @throws MissingMandatoryFieldException if the $data does not contain all the necessary information
     */
    public function send(array $data): int;
}
