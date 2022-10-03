<?php

namespace App\Http\Controllers;

use App\Models\ChartModel;
use App\Models\PendingMailModel;
use App\Notifications\SendJamaapEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    function saveMail($body)
    {
        $attachs = [];
        foreach (explode(",", $body->attachment)  as $attach) {
            if ($attach == "") {
                break;
            }
            $attachs[] = collect([
                "Name" => $body->url . str_replace(" ", "%20", $attach)
            ]);
        }
        $mail = collect([
            "FromName" => $body->mail_to_name,
            "MessageStream" =>  "outbound",
            "From" =>  $body->mail_from,
            "FromFull" => collect([
                "Email" => $body->mail_from,
                "Name" => $body->mail_from_name,
                "MailboxHash" => null
            ]),
            "To" => "\"$body->mail_to_name\" <$body->mail_to>",
            "ToFull" => [
                collect([
                    "Email" => "$body->mail_to",
                    "Name" => "$body->mail_to_name",
                    "MailboxHash" => null
                ]),
            ],
            "Cc" => null,
            "CcFull" => null,
            "Bcc" => null,
            "BccFull" => null,
            "OriginalRecipient" => null,
            "Subject" => $body->mail_subject,
            "MessageID" => $body->mail_to,
            "ReplyTo" => "info@jamaap.co.tz",
            "MailboxHash" => "SampleHash",
            "Date" => Carbon::now()->format("Y-m-d H:i:d"),
            "TextBody" => "$body->mail_body \n $body->mail_template \n $body->mail_signature",
            "HtmlBody" => "<html><body><p>$body->mail_body <br /> $body->mail_template <br /> $body->mail_signature</p></body></html>",
            "StrippedTextReply" =>  "$body->mail_body \n $body->mail_template \n $body->mail_signature",
            "RawEmail" => null,
            "Tag" =>  "",
            "Headers" =>  [
                collect([
                    "Name" => "X-Header-Test",
                    "Value" => null
                ])
            ],
            "Attachments" => $attachs,
        ]);
        ChartModel::addMail($mail,$body->mail_to);
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
