<?php

namespace App\Http\Controllers;

use App\Models\PendingMailModel;
use App\Notifications\SendJamaapEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class EmailController extends Controller
{
    //

    public function send(){
        $pending = PendingMailModel::where("state","!=",1)->first();
        Notification::route('mail', [
            $pending->to => $pending->to_name,
        ])->notify(new SendJamaapEmail($pending));
        $pending->state = 1;
        $pending->save();
        print("SENT");
    }

    public function jamaap()
    {
        $response = Http::get('http://jamaap.grandtracks.com/get_emails');
        $bodies = json_decode($response->body());
        foreach ($bodies as $body) {
            PendingMailModel::create([
                "to" => $body->mail_to,
                "to_name" => $body->mail_to_name,
                "reply_to" => $body->mail_reply_to,
                "mail_from" => $body->mail_from,
                "from_name" => $body->mail_from_name,
                "subject" => $body->mail_subject,
                "body" => $body->mail_body,
                "template" => $body->mail_template,
                "signature" => $body->mail_signature,
                "attachment" => $body->mail_attachment,
                "user" => $body->mail_user,
                "state" => $body->mail_state,
                "type" => $body->mail_type,
                "url" => "http://jamaap.grandtracks.com/",
            ]);
        }
    }

    public function skyland()
    {
        $response = Http::get('http://skyland.grandtracks.com/get_emails');
        $bodies = json_decode($response->body());
        foreach ($bodies as $body) {
            PendingMailModel::create([
                "to" => $body->mail_to,
                "to_name" => $body->mail_to_name,
                "reply_to" => $body->mail_reply_to,
                "mail_from" => $body->mail_from,
                "from_name" => $body->mail_from_name,
                "subject" => $body->mail_subject,
                "body" => $body->mail_body,
                "template" => $body->mail_template,
                "signature" => $body->mail_signature,
                "attachment" => $body->mail_attachment,
                "user" => $body->mail_user,
                "state" => $body->mail_state,
                "type" => "system",
                "url" => "http://skyland.grandtracks.com/",
            ]);
        }
    }
}
