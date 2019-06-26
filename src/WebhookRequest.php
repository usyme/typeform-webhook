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

use Symfony\Component\HttpFoundation\Request;
use Usyme\Typeform\Webhook\Model\Response;

/**
 * Class WebhookRequest
 * @package Usyme\Typeform\Webhook
 *
 * NOTE: This class should be used directly if you're building an app
 * based on symfony framework, or you use the symfony/http-foundation library
 * library as http layer for your project.
 */
class WebhookRequest
{
    public const HEADER_SIGNATURE_KEY = 'typeform-signature';

    /**
     * @var Webhook
     */
    protected $webhook;

    /**
     * TypeformRequest constructor.
     *
     * @param Webhook $webhook
     */
    public function __construct(Webhook $webhook)
    {
        $this->webhook = $webhook;
    }

    /**
     * Use this method to automatically handle your HTTP request object
     * with the typeform submitted data.
     *
     * Use case: with symfony/form component.
     *
     * @param Request $request
     *
     * @throws Exception\AuthenticationFailedException
     * @throws Exception\BadPayloadFormatException
     */
    public function handleHttpRequest(Request $request): void
    {
        // Fetch typeform response
        $response = $this->getResponse($request);

        // Replace the request parameters by
        $request->request->replace(
        // Data presented on typeform request as array (key => value)
            $response->getFormResponseData()
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception\AuthenticationFailedException
     * @throws Exception\BadPayloadFormatException
     */
    public function getResponse(Request $request): Response
    {
        $secret  = $request->headers->get(self::HEADER_SIGNATURE_KEY);
        $payload = $request->getContent();

        return $this->webhook->getResponse($secret, $payload);
    }
}