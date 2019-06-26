# Typeform Webhook PHP
A secured PHP wrapper for [Typeform](https://developer.typeform.com/) service.

## Install
First step is to [create a new webhook endpoint](https://www.typeform.com/help/webhooks/) on your typeform account/workspace.

Second, you'll need to generate a random string. for example, via terminal:
```
$ ruby -rsecurerandom -e 'puts SecureRandom.hex(20)'
```

Then, Update the webhook setting secret on your workspace "connect" section.

Next step is to install the wrapper using [Composer](http://getcomposer.org/):
```
$ composer require usyme/typeform-webhook
```

## Receive typeform response

### Native

```php
require __DIR__ . '/../vendor/autoload.php';

use Usyme\Typeform\Webhook\Exception\AuthenticationFailedException;
use Usyme\Typeform\Webhook\Exception\BadPayloadFormatException;
use Usyme\Typeform\Webhook\Webhook;

$webhook = new Webhook('{personal_key}');

try {
    $response = $webhook->getResponse('{secret_key_from_header}', '{response_payload}');
} catch (AuthenticationFailedException $exception) {
    // Invalid received secret key
} catch (BadPayloadFormatException $exception) {
   // Bad received response payload format
}
```

### Symfony

This library is built for project based on Symfony, that's why we prepared some class helpers to simplify the integration of typeform with `symfony/http-foundation` & `symfony/form` components.

```php
class TypeformController
{
    /**
     * @param Request        $request
     * @param WebhookRequest $webhookRequest
     *
     * @return Response
     */
    public function webhook(Request $request, WebhookRequest $webhookRequest): Response
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
```

## Questions?

If you have any questions please [open an issue](https://github.com/usyme/typeform-webhook/issues/new).

## License

This library is released under the MIT License. See the bundled [LICENSE](https://github.com/usyme/typeform-webhook/blob/master/LICENSE) file for details.