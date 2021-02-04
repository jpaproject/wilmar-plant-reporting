<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyFirstNotification;
use App\Notifications\InvoicePaid;
use NotificationChannels\Telegram\TelegramMessage as TelegramMessage;
// use TelegramMessage;

use GuzzleHttp\Psr7\Request as Req;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendNotification()
    {

        $client  = new Client();
        $url = "https://api.telegram.org/bot987970005:AAHW-I-lXOJYNGxNWqC6H6D6_scwznYw3zg/sendMessage"; //<== ganti jadi token yang kita tadi
        $data    = $client->request('GET', $url, [
            'json' => [
                "chat_id" => 7, //<== ganti dengan id_message yang kita dapat tadi
                "text" => "\nHello Guys :  ", 
                "disable_notification" => true
            ]
        ]);

        $json = $data->getBody();

        dd($json);
    }
}
