<?php

namespace RobertSeghedi\LAS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model, Request;
use Illuminate\Support\Facades\Crypt, Illuminate\Contracts\Encryption\DecryptException;

class SecureLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'robertseghedi_secure_logs';

    protected $fillable = ['user', 'string', 'ip', 'browser', 'os'];

    protected $hidden = ['ip', 'browser', 'os'];
}
