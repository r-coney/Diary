<?php
namespace Domain\DataConversion;

use Domain\UserAccount\Models\User\User;
use Domain\DiaryApp\Models\User\Id as DiaryAppUserId;
use Domain\DiaryApp\Models\User\User as DiaryAppUser;

class UserConverter
{
    /**
     * UserAccountコンテキストのUserをDiaryAppコンテキストのUserに変換
     *
     * @param User $user
     * @return DiaryAppUser
     */
    public function toDiaryApp(User $user): DiaryAppUser
    {
        return new DiaryAppUser(
            new DiaryAppUserId($user->id()),
            $user->name()
        );
    }
}
