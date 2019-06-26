<?php
/**
 * This file is part of the CosaVostra, Usyme package.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Usyme\Typeform\Webhook\Exception;

use Exception;
use Throwable;

class BadPayloadFormatException extends Exception
{
    public function __construct($message = 'Bad typeform payload format.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}