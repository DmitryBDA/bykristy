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
        'status'
    ];

    public function setAttr($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
