<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['notifiable_id', 'notifiable_type', 'data', 'read_at'];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
