<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'status',
        'service_id',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id','service_id');
    }

    public function setAttr($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
