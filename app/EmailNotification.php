<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    protected $table = 'email_notification_settings';
    protected $fillable = ['host', 'port', 'username','password','encryption','receiver','sender'];
}
