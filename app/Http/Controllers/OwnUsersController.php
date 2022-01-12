<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        $redmineId = $request->get("redmine_id");
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

    public function getAllTimeEntries(Request $request)
    {
        $requestPeriod = $request->get("period");
        $redmineId = $request->get("id");
        switch ($requestPeriod) {
            case  "prevday":
                $dateFrom = new \DateTimeImmutable("today");
                $dateFrom = $dateFrom->modify("-1 days");
                $dateTo = new \DateTimeImmutable("today");
            case  "today":
                $dateFrom = new \DateTimeImmutable("today");
                $dateTo = $dateFrom->modify("+1 days");
            case  "curmonth":

            case  "prevmonth":

            default:
                $dateFrom = new \DateTimeImmutable("today");
                $dateFrom->modify("-1 day");
                $dateTo = new \DateTimeImmutable("today");
        }

        $allUsers = RedmineUsersRepository::getAllUserModels();
        if (!is_iterable($allUsers)) {
            throw new \ErrorException('Userlist is empty');
        }

        $redmineids = [];
        foreach ($allUsers as $user) {
            $redmineids[] = $user->redmine_id;
        }

        $fullUserInfo = RedmineUsersRepository::getTimeEntries([$redmineId], $dateFrom, $dateTo);


        return view('userlist', ['allUsers' => $allUsers]);
    }
}
