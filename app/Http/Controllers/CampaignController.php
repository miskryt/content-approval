<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Campaign;
use App\Models\CampaignStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /* Show campaigns list */
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        if($user->isSuperAdmin())
        {
            $campaigns = Campaign::with('users')
                ->with('statuses')
                ->orderByDesc('created_at')
                ->where('campaigns.name', 'like', '%'.$search.'%')
                ->sortable()
                ->paginate(10);
        }
        else
        {
            $campaigns = Campaign::whereHas('users')
                ->where('campaigns.name', 'like', '%'.$search.'%')
                ->sortable()//->toSql();
                ->paginate(10);

            //dd($campaigns);
        }

        return view('campaigns.index', compact('campaigns', 'search'));
    }

    /* Open view to create new campaign */
    public function create()
    {
        $statuses = CampaignStatus::pluck('name','id')->all();
        return view('campaigns.create', compact('statuses'));
    }

    /* Open view to edit existing campaign */
    public function edit(Request $request, $id)
    {
        $search = $request->input('search');

        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $owners = $campaign->getOwners();
        $statuses = CampaignStatus::pluck('name','id')->all();

        $users = User::with('role')
            ->whereHas('role', function($q)
            {
                $q->where('name', 'Client');
            })
           ->whereHas('campaigns', function ($q) use($id)
            {
                $q->where('campaign_user.campaign_id', $id);
            })
            ->where(function($q) use($search, $id)
            {
                if($search)
                {
                    $q->where('users.first_name', 'like', '%'.$search.'%')
                        ->orWhere('users.last_name', 'like', '%'.$search.'%')
                        ->orWhere('users.username', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%');
                }
            })
            ->sortable()
            ->paginate(10);

        return view('campaigns.edit',compact('campaign', 'users', 'search', 'id', 'owners', 'statuses'));
    }


    /* Save data for a new campaign */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|max:255|min:3',
            'user_id' => ''
        ],
        [
            'name.required' => 'You have to write name!',
            'user_id.required' => 'You have to assigns owner of the campaign!'
        ]);

        $input = $request->all();

        $campaign = Campaign::create($input);

        return redirect()->route('campaigns.index')
            ->with('message','Campaign created successfully');
    }

    /* Update data for a existing campaign */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255|min:3'
        ]);

        $input = $request->all();

        $campaign = Campaign::find($id);
        $campaign->name = $input['name'];
        $campaign->user_id = $input['user_id'] ?? null;
        $campaign->campaign_status_id = $input['campaign_status_id'];
        $campaign->description = $input['description'];
        $campaign->long_description = $input['long_description'];

        $campaign->save();

        return redirect()->route('campaigns.index')
            ->with('message','Campaign <span style="font-weight: bold">'.$campaign->name.'</span> updated successfully');
    }

    /* Delete campaign by id */
    public function destroy($id)
    {
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $users = User::whereHas('role', function($q)
        {
            $q->where('name', 'Influencer');
            $q->orWhere('name', 'Client');
        })
        ->whereHas('campaigns', function ($q) use($id)
        {
            $q->where('campaign_user.campaign_id', $id);
        })->get();

        //ddd($users);

        $campaign->removeMembers($users);

        Campaign::find($id)->delete();

        return redirect()->route('campaigns.index')
            ->with('success','Campaign deleted successfully');
    }

    /* Open view to show existing campaign */
    public function show(Request $request, $id)
    {
        $user = Auth::user();

        if($user->role->name === 'Super-Admin')
            return $this->showAdmin($request, $id);

        if($user->role->name === 'Influencer')
            return $this->showMember($request, $id);

        if($user->role->name === 'Client')
            return $this->showClient($request, $id);
    }


    private function showMember(Request $request, $id)
    {
        $search = $request->input('search');
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $assets = Asset::with('user')->get();

        $user = Auth::user();

        return view('campaigns.members.index', compact('campaign', 'user', 'assets', 'search'));
    }

    private function showClient(Request $request, $id)
    {
        $search = $request->input('search');
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $query = User::whereHas('role', function($q)
        {
            $q->where('name', 'Influencer');
        })
            ->whereHas('campaigns', function ($q) use($id)
            {
                $q->where('campaign_user.campaign_id', $id);
            })

            ->where(function($q) use($search, $id)
            {
                if($search)
                {
                    $q->where('users.first_name', 'like', '%'.$search.'%')
                        ->orWhere('users.last_name', 'like', '%'.$search.'%')
                        ->orWhere('users.username', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%');
                }
            })
            ->sortable();

        $users = $query->paginate(10);

        return view('campaigns.show', compact('campaign', 'users', 'search'));
    }

    private function showAdmin(Request $request, $id)
    {
        $search = $request->input('search');
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $query = User::whereHas('role', function($q)
        {
            $q->where('name', 'Influencer');
        })
            ->whereHas('campaigns', function ($q) use($id)
            {
                $q->where('campaign_user.campaign_id', $id);
            })

            ->where(function($q) use($search, $id)
            {
                if($search)
                {
                    $q->where('users.first_name', 'like', '%'.$search.'%')
                        ->orWhere('users.last_name', 'like', '%'.$search.'%')
                        ->orWhere('users.username', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%');
                }
            })
            ->sortable();

        $users = $query->paginate(10);

        return view('campaigns.show', compact('campaign', 'users', 'search'));
    }

    /* Open view to add members to existing campaign */
    public function addMembersView(Request $request, $id)
    {
        $search = $request->input('search');
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $query = User::whereDoesntHave('campaigns', function ($q) use($id)
        {
            $q->where('campaign_user.campaign_id', $id);
        })
        ->whereHas('role', function($q)
        {
            $q->where('name', 'Influencer');
        })
        ->where(function($q) use($search, $id)
        {
            if($search)
            {
                $q->where('users.first_name', 'like', '%'.$search.'%')
                    ->orWhere('users.last_name', 'like', '%'.$search.'%')
                    ->orWhere('users.username', 'like', '%'.$search.'%')
                    ->orWhere('users.email', 'like', '%'.$search.'%');
            }
        })
        ->sortable();

        $users = $query->paginate(10);

        return view('campaigns.members.add', compact('users', 'search', 'campaign'));
    }

    /* Save data to add members to existing campaign */
    public function addMembers(Request $request, $id)
    {
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $members = $request->input('user_id');

        $campaign->addMembers(User::findMany($members));

        return redirect()->route('campaigns.show', $id)->with('message','Members have been added');
    }

    /* Remove members from existing campaign */
    public function removeMembers(Request $request, $id)
    {
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $members = $request->input('user_id');

        $campaign->removeMembers(User::findMany($members));

        return redirect()->route('campaigns.show', $id)->with('message','Members have been removed');
    }

    /* Open view to add clients to existing campaign */
    public function addClientsView(Request $request, $id)
    {
        $search = $request->input('search');
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $query = User::whereDoesntHave('campaigns', function ($q) use($id)
        {
            $q->where('campaign_user.campaign_id', $id);
        })
            ->whereHas('role', function($q)
            {
                $q->where('name', 'Client');
            })
            ->whereDoesntHave('campaigns', function ($q) use($id)
            {
                $q->where('campaign_user.campaign_id', $id);
            })
            ->where(function($q) use($search, $id)
            {
                if($search)
                {
                    $q->where('users.first_name', 'like', '%'.$search.'%')
                        ->orWhere('users.last_name', 'like', '%'.$search.'%')
                        ->orWhere('users.username', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%');
                }
            })
            ->sortable();

        $users = $query->paginate(10);

        return view('campaigns.clients.add', compact('users', 'search', 'campaign'));
    }

    /* Save data to add clients to existing campaign */
    public function addClients(Request $request, $id)
    {
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $members = $request->input('user_id');

        $campaign->addMembers(User::findMany($members));

        return redirect()->route('campaigns.edit', $id)->with('message','Clients have been added');
    }

    /* Remove clients from existing campaign */
    public function removeClients(Request $request, $id)
    {
        $campaign = Campaign::find($id);

        if(!$campaign)
            return abort(404);

        $members = $request->input('user_id');

        $campaign->removeMembers(User::findMany($members));

        return redirect()->route('campaigns.edit', $id)->with('message','Clients have been removed');
    }

    /* Open view to show members's assets in existing campaign */
    public function showMemberAssetsView($id, $uid)
    {
        $campaign = Campaign::find($id);
        $user = User::find($uid);

        if(!$campaign)
            return abort(404);

        if(!$user)
            return abort(404);

        $assets = Asset::whereHas('user', function ($q) use($uid, $id)
        {
            $q->where('assets.user_id', $uid)->where('campaign_id', $id);
        })->get();

        return view('assets.index', compact('campaign', 'user', 'assets'));
    }

    public function createMemberAssets($id, $uid)
    {
        $campaign = Campaign::find($id);
        $user = User::find($uid);

        if(!$campaign)
            return abort(404);

        if(!$user)
            return abort(404);


        return view('assets.create', compact('campaign', 'user'));
    }
}
