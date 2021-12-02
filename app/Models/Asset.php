<?php

namespace App\Models;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use Venturecraft\Revisionable\RevisionableTrait;

class Asset extends Model implements UrlRoutable
{
    protected $revisionCreationsEnabled = false;

    use HasFactory;
    use SoftDeletes;
    use RevisionableTrait;
    use Sortable;

    protected $fillable = [
        'caption',
        'content_type',
        'file_type',
        'user_id',
        'campaign_id'
    ];

    protected $sortable =
    [   'caption',
        'content_type',
        'file_type',
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

    public function status()
    {
        return $this->belongsTo(AssetStatus::class, 'asset_status_id');
    }

    public function canBeOpened()
    {
        $user = Auth::user();

        if(!$user->isSuperAdmin())
        {
            if($this->status->id === AssetStatus::where('name', 'new')->first()->id)
            {
                return false;
            }
        }

        return true;
    }
}
