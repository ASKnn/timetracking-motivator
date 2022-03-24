<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RedmineTimeEntriesService;
use App\Services\RedmineUsersRepository;
use App\Services\RedmineConnector;
use Illuminate\Http\Request;


class OwnUsersController extends Controller
{
    public function addOwnUser(Request $request)
    {
        $validated = $request->validate([
            'redmine_id' => 'required|integer',
        ]);

        $redmineId = (int)$request->get("redmine_id");
        if (RedmineUsersRepository::isExistInApp($redmineId)) {
            return back()->with('user_status_exist', 'User with id ' . $redmineId . ' is exist.');
        } else {
            $newUser = RedmineUsersRepository::createRMUserInApp($redmineId);
            return back()->with('user_status_exist', 'User ' . $newUser->surname . ' successfully created.');
        }
    }

    public function getAllUsers()
    {
        $allUsers = RedmineUsersRepository::getAllUserModels();
        if (!is_iterable($allUsers)) {
            throw new \ErrorException('Userlist is empty');
        }

        $redmineids = [];
        foreach ($allUsers as $user) {
            $redmineids[] = $user->redmine_id;
        }

        $fullUserInfo = RedmineUsersRepository::getUsersFromRedmineByRedmineId($redmineids);

        return view('userlist', ['allUsers' => $fullUserInfo]);
    }

    /**
     * Get all time entries for period
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \ErrorException
     */
    public function getAllTimeEntries(Request $request)
    {
        $requestPeriod = $request->get("period");
        $redmineId = $request->get("id");
        switch ($requestPeriod) {
            case  "prevday":
                $dateFrom = new \DateTimeImmutable("today");
                $dateFrom = $dateFrom->modify("-1 days");
                $dateTo = new \DateTimeImmutable("today");
                break;
            case  "today":
                $dateFrom = new \DateTimeImmutable("today");
                $dateTo = $dateFrom->modify("+1 days");
                break;
            case  "curmonth":
                break;
            case  "prevmonth":
                break;
            default:
                $dateFrom = new \DateTimeImmutable("today");
                $dateFrom = $dateFrom->modify("-1 day"); // todo разобраться с UTC+3
                $dateTo = new \DateTimeImmutable("today");
                break;
        }


        $allUsers = RedmineUsersRepository::getAllUserModels();
        if (!is_iterable($allUsers)) {
            throw new \ErrorException('Userlist is empty');
        }

        $redmineids = [];
        $userResources = [];
        foreach ($allUsers as $user) {
            $redmineids[] = $user->redmine_id;
            $userResources[$user->redmine_id] = $user;
        }
        unset($allUsers);

        // todo replace RedmineUsersRepository to dependency inversion
        $timeEntries = RedmineUsersRepository::getTimeEntries([$redmineId], $dateFrom, $dateTo);
        $grouped = new RedmineTimeEntriesService($timeEntries);
        $groupedEntries = $grouped->getGroupedByUser();
        unset($grouped);

        return view('time_entries', [
            'groupedEntries' => $groupedEntries,
            'userResources' => $userResources
        ]);
    }
}
