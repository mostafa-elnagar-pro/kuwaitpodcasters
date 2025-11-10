<?php

namespace App\Enums;


enum NotificationType: string
{
    case ADMIN_MESSAGE = 'admin_message';
    case NEW_FOLLOWER = 'new_follower';
    case NEW_CHANNEL = 'new_channel';
    case NEW_SEASON = 'new_season';
    case NEW_PODCAST = 'new_podcast';
    case PODCAST_LIKE = 'podcast_like';
}
