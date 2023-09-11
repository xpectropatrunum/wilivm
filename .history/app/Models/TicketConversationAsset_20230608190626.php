<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TicketConversationAsset extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = [
        'ticket_conversation_id',
        'file',
    ];

    function getMimeAttribute(){
        return array_reverse(explode(".", $this->attributes["file"]))[0];
    }


  
  
}
