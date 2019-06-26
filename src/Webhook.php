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

namespace Usyme\Typeform\Webhook;

use Usyme\Typeform\Webhook\Exception\AuthenticationFailedException;
use Usyme\Typeform\Webhook\Exception\BadPayloadFormatException;
use Usyme\Typeform\Webhook\Model\Response;

class Webhook
{
    /**
     * @var string
     */
    protected $key;

    /**
     * Form constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @param string|null $secret
     * @param string|null $payload
     *
     * @return Response
     *
     * @throws AuthenticationFailedException|BadPayloadFormatException
     */
    public function getResponse(?string $secret, ?string $payload): Response
    {
        if (!$this->isAuthenticated($secret, $payload)) {
            throw new AuthenticationFailedException();
        }

        return new Response($this->jsonDecode($payload));
    }

    /**
     * @param $data
     *
     * @return array
     *
     * @throws BadPayloadFormatException
     */
    protected function jsonDecode($data): array
    {
        $decoded = json_decode($data, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadPayloadFormatException();
        }

        return $decoded;
    }

    /**
     * @param string $secret
     * @param string $payload
     *
     * @return bool
     */
    protected function isAuthenticated(?string $secret, ?string $payload): bool
    {
        return $secret === 'sha256=' . $this->encode($payload);
    }

    /**
     * Encrypt the payload using SHA256 algorithm
     * And return it's base64 value.
     *
     * @param string $payload
     *
     * @return string
     */
    private function encode(?string $payload): string
    {
        return base64_encode(
            hash_hmac('sha256', $payload, $this->key, true)
        );
    }
}