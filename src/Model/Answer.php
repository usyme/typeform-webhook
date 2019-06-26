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

class Answer extends AbstractObject
{
    protected static $oneObjectMap = [
        'field' => Field::class
    ];

    /**
     * @return Field
     */
    public function getField(): ?Field
    {
        return $this->get('field');
    }

    /**
     * @return string|null
     */
    public function getRef(): ?string
    {
        if (null !== $field = $this->getField()) {
            return $field->getRef();
        }

        return null;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->get('type');
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if ($this->getType() === 'choice') {
            if (is_array($choice = $this->get('choice')) && array_key_exists('label', $choice)) {
                return $choice['label'];
            }

            return null;
        }

        return $this->get($this->getType());
    }
}