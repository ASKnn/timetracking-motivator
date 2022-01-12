<?php
declare(strict_types=1);

namespace App\Services;

use Redmine\Client\Client;

/**
 * Class RedmineConnector
 * @package App\Services
 * @see https://github.com/kbsali/php-redmine-api/blob/v2.x/docs/usage.md
 */
class RedmineConnector implements RedmineConnectorInterface
{
    protected function getApiUrl() : string
    {
        $apiUrl = env('REDMINE_API_URL');
        if (!$apiUrl) {
            throw new \ErrorException('Redmine API url is not set');
        }

        return $apiUrl;
    }

    protected function getApiKey() : string
    {
        $apiKey = env('REDMINE_API_KEY');
        if (!$apiKey) {
            throw new \ErrorException('Redmine API key is not set');
        }

        return $apiKey;
    }

    public function getConnector() : Client
    {
        $client = new \Redmine\Client\NativeCurlClient($this->getApiUrl(), $this->getApiKey());

        return $client;
    }
}
