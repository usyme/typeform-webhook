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

class Field extends AbstractObject
{
    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->get('type');
    }

    /**
     * @return string
     */
    public function getRef(): ?string
    {
        return $this->get('ref');
    }
}