<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketReply extends Model
{
    Use HasFactory, Notifiable, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'ticket_reply';

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
