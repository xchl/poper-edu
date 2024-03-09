<?php
/**
 * Created by xuchengliang
 * Date: 2024/3/5 17:21
 */

namespace App\Passport\Grant;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\RequestEvent;
use Psr\Http\Message\ServerRequestInterface;

class PasswordGrant extends \League\OAuth2\Server\Grant\PasswordGrant
{
    /**
     * Validate the client.
     *
     * @param ServerRequestInterface $request
     *
     * @throws OAuthServerException
     *
     * @return ClientEntityInterface
     */
    protected function validateClient(ServerRequestInterface $request)
    {
        [$clientId, $clientSecret] = $this->getClientCredentials($request);

        if ($this->clientRepository->validateClient($clientId, $clientSecret, $this->getIdentifier()) === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::CLIENT_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidClient($request);
        }

        $client = $this->getClientEntityOrFail($clientId, $request);
        if(!$client->provider){
            $guard = $this->getRequestParameter('guard', $request );
            $client->provider = config('auth.guards.'.$guard.'.provider');
        }

        // If a redirect URI is provided ensure it matches what is pre-registered
        $redirectUri = $this->getRequestParameter('redirect_uri', $request, null);

        if ($redirectUri !== null) {
            if (!\is_string($redirectUri)) {
                throw OAuthServerException::invalidRequest('redirect_uri');
            }

            $this->validateRedirectUri($redirectUri, $client, $request);
        }

        return $client;
    }

}
