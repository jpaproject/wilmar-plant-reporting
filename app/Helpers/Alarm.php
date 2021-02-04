<?php
namespace App\Helpers;

use App\AlarmList;
use App\TelegramNotification;
use Illuminate\Support\Facades\Config;
use App\Notifications\AlarmTelegram;
use Illuminate\Support\Facades\Mail;
use App\EmailNotification;

class Alarm
{
    // Helper Function for save alarm list
    public function saveAlarmList($event, $msg){
        $data['tstamp'] = date('Y-m-d H:i:s');
        $data['event'] = $event;
        $data['text'] = $msg;
        AlarmList::create($data);
        try {
             \App\CloudAlarmList::create($data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // Helper Function for send alarm to telegram
    public function sendTelegram($msg){
        $telegramNotifications = TelegramNotification::orderBy('id', 'desc')->get();
        if ($telegramNotifications) {
            foreach ($telegramNotifications as $telegramNotification) {
                Config::set('services.telegram-bot-api.token', $telegramNotification->bot_token);
                try {
                    $user = \App\User::first();
                    // dd($user);
                    $user->notify(new AlarmTelegram($telegramNotification->channel_id, $msg));
                    // return back()->with('success-test', 'Successfully Send Telegram !');
                } catch (\Throwable $th) {
                    // return back()->with('fail-test', $th->getMessage());
                }
            }
        } else {
            return back()->with('delete', 'Fill Telegram Setting First !');
        }
    }

    // Helper Function for send alarm to email
    public function sendEmail($event, $message,$subject, $material)
    {
        $EmailNotification = EmailNotification::orderBy('id', 'desc')->take(1)->first();
        if ($EmailNotification) {
            $to = explode(',', $EmailNotification->receiver);
            Config::set('mail.host', $EmailNotification->host);
            Config::set('mail.port', $EmailNotification->port);
            Config::set('mail.username', $EmailNotification->username);
            Config::set('mail.password', $EmailNotification->password);
            Config::set('mail.encryption', $EmailNotification->encryption);
            try {
                Mail::send('email', ['event' => $event, 'pesan' => $message], function ($message) use ($subject, $to, $EmailNotification) {
                    $message->subject($subject);
                    $message->from('donotreply@jpa-automation.com', $EmailNotification->sender);
                    $message->to($to);
                });
                echo date('Y-m-d H:i:s').'-> Successfully Send Email '. $material;
                echo PHP_EOL;

            } catch (\Throwable $e) {
                echo date('Y-m-d H:i:s').'-> Fail email '. $e->getMessage();
                echo PHP_EOL;

            }
        } else {
            echo date('Y-m-d H:i:s').'-> Fail email Fill SMTP Setting First ! ';
            echo PHP_EOL;

        }
    }
}