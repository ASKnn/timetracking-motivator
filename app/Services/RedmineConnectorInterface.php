<?php

namespace App\Services;
use Redmine\Client\Client;

interface RedmineConnectorInterface
{
    public function getConnector() : Client;
}