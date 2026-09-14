<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['support_session_id', 'sender_id', 'sender_type', 'message'])]
class SupportMessage extends Model
{
    public function session(): BelongsTo
    {
        return $this->belongsTo(SupportSession::class, 'support_session_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
