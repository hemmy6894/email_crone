<?php

namespace App\Http\Controllers;

use App\Models\ChartModel;
use App\Models\PendingMailModel;
use App\Notifications\SendJamaapEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class EmailController extends Controller
{
    //

    public function send()
    {
        $pendings = PendingMailModel::where("state", "!=", 1)->whereNotNull('to')->limit(5)->get();
        foreach ($pendings as $pending) {
            Notification::route('mail', [
                $pending->to => $pending->to_name,
            ])->notify(new SendJamaapEmail($pending));
            $pending->state = 1;
            $pending->save();
            print("SENT");
        }
    }

    public function jamaap()
    {
        $response = Http::get(env("LINK_JAMAAP", "localhost/") . 'get_emails');
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
                "url" => env("LINK_JAMAAP", "localhost/"),
            ]);
            $this->saveMail($body);
        }
    }

    public function createNewMail(Request $request){
        $body = new PendingMailModel(
            [
                "to" => $request->mail_to,
                "to_name" => $request->mail_to_name,
                "reply_to" => $request->mail_reply_to,
                "mail_from" => $request->mail_from,
                "from_name" => $request->mail_from_name,
                "subject" => $request->mail_subject,
                "body" => $request->mail_body,
                "template" => $request->mail_template,
                "signature" => $request->mail_signature,
                "attachment" => $request->mail_attachment,
                "user" => $request->mail_user,
                "state" => $request->mail_state,
                "type" => $request->mail_type,
                "url" => env("LINK_JAMAAP", "localhost/"),
            ]
        );
        return $body;
        // PendingMailModel::create([
        //     "to" => $body->mail_to,
        //     "to_name" => $body->mail_to_name,
        //     "reply_to" => $body->mail_reply_to,
        //     "mail_from" => $body->mail_from,
        //     "from_name" => $body->mail_from_name,
        //     "subject" => $body->mail_subject,
        //     "body" => $body->mail_body,
        //     "template" => $body->mail_template,
        //     "signature" => $body->mail_signature,
        //     "attachment" => $body->mail_attachment,
        //     "user" => $body->mail_user,
        //     "state" => $body->mail_state,
        //     "type" => $body->mail_type,
        //     "url" => env("LINK_JAMAAP", "localhost/"),
        // ]);
        // $this->saveMail($body);
    }

    function saveMail($body)
    {
        ChartModel::create([
            "OriginalMail" => $mail ?? $body->mail_to,
            "FromName" => json_encode($body->mail_to_name),
            "MessageStream" => "outbound",
            "FromFull" => json_encode("{'Name' : '$body->mail_from_name','Email' : '$body->mail_from',}"),
            "To" => $body->mail_to,
            "ToFull" => json_encode("[{'Name' : '$body->mail_to_name','Email' : '$body->mail_to'}]"),
            "Cc" => $body->mail_reply_to,
            "CcFull" => json_encode("[{'Name' : 'JAMAAP','Email' : '$body->mail_reply_to',}]"),
            "Bcc" => null,
            "BccFull" => null,
            "OriginalRecipient" => $body->mail_to,
            "Subject" => $body->mail_subject,
            "MessageID" => $body->mail_to,
            "ReplyTo" => $body->mail_reply_to,
            "MailboxHash" => $body->mail_reply_to,
            "Date" => $body->mail_created_at,
            "TextBody" => "$body->mail_body \n $body->mail_template \n $body->mail_signature",
            "HtmlBody" => null,
            "StrippedTextReply" => null,
            "RawEmail" => null,
            "Tag" => $body->mail_id,
            "Headers" => null,
            "Attachments" => null,
        ]);
    }

    public function skyland()
    {
        $response = Http::get(env("LINK_SKYLAND", "localhost/") . 'get_emails');
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
                "url" => env("LINK_SKYLAND", "localhost/"),
            ]);
        }
    }
}
