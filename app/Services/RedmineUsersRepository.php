<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\RedmineUsers;
use Illuminate\Database\Eloquent\Collection;

class RedmineUsersRepository
{
    protected static $connector;

    public static function getAllUserModels() : Collection
    {
        $allrmUsers = RedmineUsers::all();

        return $allrmUsers;
    }

    public static function isExistInApp(int $redmineId) : bool
    {
        $user = RedmineUsers::where('redmine_id', $redmineId)
            ->first();

        return $user ? true : false;
    }

    public static function getModelByRedmineId(int $id) : RedmineUsers
    {
        $user = RedmineUsers::where('redmine_id', $id)
            ->first();

        return $user;
    }

    public static function getModelById(int $id) : RedmineUsers
    {
        $user = RedmineUsers::where('id', $id)
            ->first();

        return $user;
    }

    public static function createRMUserInApp(int $redmineId) : RedmineUsers
    {
        $user = self::getFullRMUserOrFail($redmineId);

        $newUser = new RedmineUsers;
        $newUser->surname = $user['lastname'];
        $newUser->redmine_id = $user['id'];
        $newUser->save();

        return $newUser;
    }

    protected static function getFullRMUserOrFail(int $redmineId, bool $fullInfo = false)
    {
        $connector = self::getConnector();
        $params = $fullInfo ? [
            'include' => [
                'memberships',
                'groups',
                'api_key',
                'status',
            ],
        ] : [];

        $user = $connector->getConnector()->getApi('user')->show($redmineId, []);

        if (!is_array($user)) {
            throw new \ErrorException('Redmine user id ' .$redmineId.' is not found.');
        }

        return $user['user'];
    }

    /**
     * @param array $redmineIds
     */
    public static function getUsersFromRedmineByRedmineId(array $redmineIds) : array
    {
        $users = [];
        foreach ($redmineIds as $id) {
            if (!is_integer($id)) {
                continue;
            }
            $users[] = self::getFullRMUserOrFail($id);
        }

        return $users;
    }

    protected static function getConnector() : RedmineConnectorInterface
    {
        if (static::$connector instanceof RedmineConnectorInterface) {
            return static::$connector;
        } else {
            return static::$connector = new RedmineConnector();
        }
    }

    public static function getTimeEntries(array $redmineIds, \DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo)
    {
        //$redmineIds = [190,340,81,297,177];
        $connector = self::getConnector();
        $timeEntries = [];
        foreach ($redmineIds as $id) {
            $array = [
                "from" => $dateFrom->format("Y-m-d"),
                "to" => $dateTo->format("Y-m-d"),
                'user_id' => $id
            ];

            $timeEntries[] = $connector->getConnector()->getApi('time_entry')->all($array);
        }
        dd($timeEntries);
    }
}
