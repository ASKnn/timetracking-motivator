<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RedmineConnector;

class RedmineController extends Controller
{
    public function show(RedmineConnector $connector)
    {
        $client = $connector->getConnector();
        $test = $client->getApi('time_entry')->all([
            'user_id' => 190,
            'from'=>'2021-11-01',
            'to'=>'2021-12-03',
            'limit'=>100
        ]);
        dd($test);
    }

    public function showUsers(RedmineConnector $connector)
    {
        $client = $connector->getConnector();
        $users = $client->getApi('time_entry')->all([
            'user_id' => 190,
            'from'=>'2021-11-01',
            'to'=>'2021-12-03',
            'limit'=>100
        ]);


    }

    public function showAllEmployees(RedmineConnector $connector)
    {
        $client = $connector->getConnector();
        $res = $client->getApi('user')->show(81, [
            'include' => [
                'memberships',
                'groups',
                'api_key',
                'status',
            ],
        ]);
        dd($res);
    }
}
