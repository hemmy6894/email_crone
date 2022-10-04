<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChartModel extends Model
{
    use HasFactory;
    protected $table = "jamaap_charts";
    protected $guarded = [];

    public function scopeAddMail($query, $request,$mail = null)
    {
        $recepients = array_merge($request->ToFull,$request->CcFull,$request->CcFull);
        foreach ($recepients as $recepient) {
            $recepient = json_decode(json_encode($recepient));
            ChartModel::create([
                "OriginalMail" => $mail ?? $recepient->Email,
                "FromName" => json_encode($request->FromName),
                "MessageStream" => $request->MessageStream,
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

    public function scopeSingleMail($query,$email){
        return $query->where("OriginalMail",$email)->latest();
    }

    public function scopeAllMail($query){
        return $query->select(DB::raw("count(OriginalMail) as total_mail"),"OriginalMail", DB::raw("max(created_at) as created_at"))->orderBy("created_at","DESC")->groupBy("OriginalMail");
    }

    public function mails(){
        return $this->hasMany(ChartModel::class,"OriginalMail","OriginalMail");
    }
}
