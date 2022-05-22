<?php

namespace App\Domain;

use MyCLabs\Enum\Enum;

class ActivityTypeEnum extends Enum
{
    const CREATE_POST = 'Post Created';
    const FRIEND_ADDED = 'Friend Added';
}