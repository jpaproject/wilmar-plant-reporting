<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramNotification extends Model
{
    protected $table = 'telegram_notification_settings';
    protected $fillable = ['bot_token', 'channel_id'];
}
