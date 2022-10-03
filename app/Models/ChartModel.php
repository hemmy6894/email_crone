<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ChartModel extends Model
{
    use HasFactory;
    protected $table = "jamaap_charts";
    protected $guard = [];

    public function scopeAddMail($query, $request)
    {
        $recepients = array_merge($request->ToFull, $request->CcFull, $request->BccFull);
        foreach ($recepients as $recepient) {
            Log::error("EMail",$recepient);
            ChartModel::create([
                "OriginalMail" => $recepient->Email,
                "FromName" => $request->FromName,
                "MessageStream" => $request->MessageStream,
                "FromFull" => $request->FromFull,
                "To" => $request->To,
                "ToFull" => $request->ToFull,
                "Cc" => $request->Cc,
                "CcFull" => $request->CcFull,
                "Bcc" => $request->Bcc,
                "BccFull" => $request->BccFull,
                "OriginalRecipient" => $request->OriginalRecipient,
                "Subject" => $request->Subject,
                "MessageID" => $request->MessageID,
                "ReplyTo" => $request->ReplyTo,
                "MailboxHash" => $request->MailboxHash,
                "Date" => $request->Date,
                "TextBody" => $request->TextBody,
                "HtmlBody" => $request->HtmlBody,
                "StrippedTextReply" => $request->StrippedTextReply,
                "RawEmail" => $request->RawEmail,
                "Tag" => $request->Tag,
                "Headers" => $request->Headers,
                "Attachments" => $request->Attachments,
            ]);
        }
    }
}
