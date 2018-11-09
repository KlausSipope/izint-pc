<?php declare(strict_types=1);

namespace BookingBundle\Exception\Entity;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class MissingMandatoryFieldException extends \Exception
{
    private const MESSAGE = 'The given data has a mandatory field missing: %s';

    /**
     * @inheritDoc
     */
    public function __construct(string $field, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE, $field), $code, $previous);
    }
}
