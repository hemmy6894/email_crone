<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PendingMailModel extends Model
{
    use HasFactory;
    use Notifiable;
    protected $guarded = [];  
    protected $table = "pending_mails";

}
