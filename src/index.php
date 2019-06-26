<?php
/**
 * This file is part of the CosaVostra, Usyme package.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Usyme\Typeform\Webhook\Exception\AuthenticationFailedException;
use Usyme\Typeform\Webhook\Exception\BadPayloadFormatException;
use Usyme\Typeform\Webhook\Webhook;
use Usyme\Typeform\Webhook\WebhookRequest;

$webhook = new Webhook('your_personal_key');

try {
    $response = $webhook->getResponse('secret_key_from_header', '{response_payload}');
} catch (AuthenticationFailedException $exception) {
    // Invalid received secret key
} catch (BadPayloadFormatException $exception) {
   // Bad received response payload format
}

class Controller
{
    /**
     * @param Request        $request
     * @param WebhookRequest $webhookRequest
     *
     * @return Response
     */
    public function index(Request $request, WebhookRequest $webhookRequest): Response
    {
        try {
            // Fetch the typeform response directly with $request object.
            $response = $webhookRequest->getResponse($request);
        } catch (AuthenticationFailedException $exception) {
            // Invalid received secret key
        } catch (BadPayloadFormatException $exception) {
            // Bad received response payload format
        }

        // ...

        // Or if you want to use the symfony's form component directly
        // you need to handle your request object, we're simulating a simple
        // post request using the handleHttpRequest() method.
        try {
            // In this case we're replacing our $request->request parameters
            // by the typeform data. So our $request object is now up-to-date :)
            $webhookRequest->handleHttpRequest($request);
        } catch (AuthenticationFailedException $exception) {
            // Invalid received secret key
        } catch (BadPayloadFormatException $exception) {
            // Bad received response payload format
        }

        // ...
    }
}