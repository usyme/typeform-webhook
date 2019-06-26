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

namespace Usyme\Typeform\Webhook\Model;

class FormResponse extends AbstractObject
{
    protected static $manyObjectsMap = [
        'answers' => Answer::class
    ];

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->get('answers');
    }
}