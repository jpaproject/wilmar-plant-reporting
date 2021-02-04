<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use \App\EmailNotification;
use \App\TelegramNotification;
use App\Notifications\AlarmTelegram;
use NotificationChannels\Telegram\Telegram;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:EmailView', ['only' => 'email']);
        $this->middleware('privilege:TelegramView', ['only' => 'telegram']);
    }

    public function email()
    {

        $data['page_title'] = 'Email Notification Setting';
        $data['data_settings'] = EmailNotification::orderBy('id', 'desc')->take(1)->first();

        return view('setting.notification.email.index', $data);
    }

    public function emailStore(Request $request)
    {

        $request->validate([
            'host' => ['required'],
            'port' => ['required'],
            'username' => ['required'],
            'encryption' => ['required'],
        ]);

        $EmailNotification = EmailNotification::orderBy('id', 'desc')->take(1)->first();
        if ($EmailNotification) {
            $EmailNotification = EmailNotification::find($EmailNotification->id);
        } else {
            $EmailNotification = new EmailNotification;
        }
        $EmailNotification->host = $request->host;
        $EmailNotification->port = $request->port;
        $EmailNotification->username = $request->username;
        $EmailNotification->password = $request->password;
        $EmailNotification->encryption = $request->encryption;
        $EmailNotification->receiver = $request->receiver;
        $EmailNotification->sender = $request->sender;
        $EmailNotification->save();
        return back()->with('create', 'Setting Successfully Saved !');
    }

    public function emailTest(Request $request)
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
                Mail::send('email', ['event' => $request->event, 'pesan' => $request->message], function ($message) use ($request, $to, $EmailNotification) {
                    $message->subject($request->subject);
                    $message->from('donotreply@jpa-automation.com', $EmailNotification->sender);
                    $message->to($to);
                });
                return back()->with('success-test', 'Successfully Send Email !');
            } catch (\Throwable $e) {
                return back()->with('fail-test', $e->getMessage());
            }
        } else {
            return back()->with('delete', 'Fill SMTP Setting First !');
        }
    }

    public function telegram()
    {
        $data['page_title'] = 'Telegram Notification Setting';
        $data['data_settings'] = TelegramNotification::orderBy('id', 'desc')->take(1)->first();
        $data['telegrams'] = TelegramNotification::orderBy('id', 'desc')->get();
        return view('setting.notification.telegram.index', $data);
    }

    public function telegramCreate()
    {
        $data['page_title'] = 'Create Telegram';
        return view('setting.notification.telegram.create', $data);
    }

    public function telegramStore(Request $request)
    {
        $request->validate([
            'bot_token' => ['required'],
            'channel_id' => ['required'],
        ]);

        // $telegramNotification = TelegramNotification::orderBy('id', 'desc')->take(1)->first();
        // if ($telegramNotification) {
        //     $telegramNotification = TelegramNotification::find($telegramNotification->id);
        // } else {
        //     $telegramNotification = new TelegramNotification;
        // }

        $telegramNotification = new TelegramNotification;

        $telegramNotification->bot_token = $request->bot_token;
        $telegramNotification->channel_id = $request->channel_id;
        $telegramNotification->save();
        return redirect('setting/notification/telegram')->with('create', 'Telegram Successfully Saved !');
    }

    public function telegramEdit($id)
    {
        $data['page_title'] = 'Edit Telegram';
        $data['telegram'] = TelegramNotification::findOrFail($id);
        // dd($departement);
        return view('setting.notification.telegram.edit', $data);
    }

    public function telegramUpdate(Request $request, $id)
    {
        $request->validate([
            'bot_token' => ['required'],
            'channel_id' => ['required'],
        ]);

        // $telegramNotification = TelegramNotification::orderBy('id', 'desc')->take(1)->first();
        // if ($telegramNotification) {
        //     $telegramNotification = TelegramNotification::find($telegramNotification->id);
        // } else {
        //     $telegramNotification = new TelegramNotification;
        // }

        $telegramNotification = TelegramNotification::findOrFail($id);

        $telegramNotification->bot_token = $request->bot_token;
        $telegramNotification->channel_id = $request->channel_id;
        $telegramNotification->save();
        return redirect('setting/notification/telegram')->with('create', 'Telegram Successfully Saved !');
    }

    public function telegramDelete($id)
    {
        $telegramNotification = TelegramNotification::findOrFail($id);
        $telegramNotification->delete();
        return redirect('setting/notification/telegram')->with('delete', 'Telegram Successfully Deleted !');
    }

    public function telegramTest(Request $request)
    {
        $telegramNotifications = TelegramNotification::orderBy('id', 'desc')->get();
        if ($telegramNotifications) {
            foreach ($telegramNotifications as $telegramNotification) {
                Config::set('services.telegram-bot-api.token', $telegramNotification->bot_token);
                try {
                    $user = \App\User::first();
                    // dd($user);
                    $user->notify(new AlarmTelegram($telegramNotification->channel_id, $request->message));
                    // return back()->with('success-test', 'Successfully Send Telegram !');
                } catch (\Throwable $th) {
                    return back()->with('fail-test', $th->getMessage());
                }
            }
            return back()->with('success-test', 'Successfully Send Telegram !');
        } else {
            return back()->with('delete', 'Fill Telegram Setting First !');
        }
    }
}
