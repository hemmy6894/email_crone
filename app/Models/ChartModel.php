<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ChartModel extends Model
{
    use HasFactory;
    protected $table = "jamaap_charts";
    protected $guarded = [];

    public function scopeAddMail($query, $request)
    {
        $recepients = array_merge($request->ToFull, $request->CcFull, $request->BccFull);
        foreach ($recepients as $recepient) {
            $recepient = json_decode(json_encode($recepient));
            ChartModel::create([
                "OriginalMail" => $recepient->Email,
                "FromName" => json_encode($request->FromName),
                "MessageStream" => json_encode($request->MessageStream),
                "FromFull" => json_encode($request->FromFull),
                "To" => json_encode($request->To),
                "ToFull" => json_encode($request->ToFull),
                "Cc" => json_encode($request->Cc),
                "CcFull" => json_encode($request->CcFull),
                "Bcc" => json_encode($request->Bcc),
                "BccFull" => json_encode($request->BccFull),
                "OriginalRecipient" => json_encode($request->OriginalRecipient),
                "Subject" => json_encode($request->Subject),
                "MessageID" => json_encode($request->MessageID),
                "ReplyTo" => json_encode($request->ReplyTo),
                "MailboxHash" => json_encode($request->MailboxHash),
                "Date" => json_encode($request->Date),
                "TextBody" => json_encode($request->TextBody),
                "HtmlBody" => json_encode($request->HtmlBody),
                "StrippedTextReply" => json_encode($request->StrippedTextReply),
                "RawEmail" => json_encode($request->RawEmail),
                "Tag" => json_encode($request->Tag),
                "Headers" => json_encode($request->Headers),
                "Attachments" => json_encode($request->Attachments),
            ]);
        }
    }
}
