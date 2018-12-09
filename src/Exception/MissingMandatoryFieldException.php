<?php declare(strict_types=1);

namespace App\Exception;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class MissingMandatoryFieldException extends \Exception
{
    /**
     * @inheritDoc
     */
    public function __construct(string $field, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            sprintf('The given data has a mandatory field missing: %s', $field),
            $code,
            $previous
        );
    }
}
