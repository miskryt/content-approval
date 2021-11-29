<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Asset extends Model
{
    protected $revisionCreationsEnabled = false;
    use HasFactory;
    use SoftDeletes;
    use RevisionableTrait;

    protected $fillable = [
        'caption',
        'type',
        'user_id',
        'campaign_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
