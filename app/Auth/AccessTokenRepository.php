<?php

namespace App\Auth;

use Laravel\Passport\Bridge\AccessTokenRepository as BaseRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;

// This class exists just to return the custom token instead of the default
class AccessTokenRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        return new AccessToken($userIdentifier, $scopes, $clientEntity);
    }
}