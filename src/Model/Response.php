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

class Response extends AbstractObject
{
    protected static $oneObjectMap = [
        'form_response' => FormResponse::class
    ];

    /**
     * @return FormResponse
     */
    public function getFormResponse(): FormResponse
    {
        return $this->get('form_response');
    }

    /**
     * Get key(ref), value responses as array
     *
     * @return array
     */
    public function getFormResponseData(): array
    {
        $data         = [];
        $formResponse = $this->getFormResponse();

        foreach ($formResponse->getAnswers() as $answer) {
            $data[$answer->getRef()] = $answer->getValue();
        }

        return $data;
    }
}