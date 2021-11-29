<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kyslik\ColumnSortable\Sortable;

class Campaign extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'name',
        'description',
        'long_description',
        'user_id',
        'campaign_status_id'
    ];

    protected $sortable =
        [   'name',
            'user_id',
            'statuses',
            'description',
            'long_description',
        ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function statuses()
    {
        return $this->belongsTo(CampaignStatus::class, 'campaign_status_id');
    }


    public function addMembers($users)
    {
        foreach ($users as $user)
        {
            $this->users()->attach($user->id);
        }
    }

    public function removeMembers($users)
    {
        foreach ($users as $user)
            $this->users()->detach($user->id);
    }

    public function getOwners(): Collection
    {
        $query = User::whereHas('role', function($q)
        {
            $q->where('name', 'Client');
        })
            ->whereHas('campaigns', function ($q)
            {
                $q->where('campaign_user.campaign_id', $this->id);
            });

        $users = $query->get();

        return $users;
    }

}
