<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Sortable;

    private $newAssets = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'role_id',
        'password',
    ];

    protected $sortable =
    [   'first_name',
        'last_name',
        'username',
        'email',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role_id === Role::where('name', 'Super-Admin')->first()->id;
    }

    public function isClient(): bool
    {
        return $this->role_id === Role::where('name', 'Client')->first()->id;
    }

    public function isMember(): bool
    {
        return $this->role_id === Role::where('name', 'Influencer')->first()->id;
    }

    public function hasNewAssets()
    {
        foreach ($this->assets as $asset)
        {
            if($asset->status->name === AssetStatus::where('name', 'New')->first()->name)
            {
                $this->newAssets[] = $asset;
            }
        }

        if(count($this->newAssets()) > 0)
        {
            return true;
        }
    }

    public function newAssets()
    {
        return ($this->newAssets);
    }
}
