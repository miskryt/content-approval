<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetStatus;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /* Save data for a new asset */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'caption' => 'required|min:3',
            'content_type' => 'required|min:5',
            'file' => 'mimetypes:image/jpeg,image/png,video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ],
        [
            'caption.required' => 'Please, fill in the caption!',
            'content_type.required' => 'Please, fill in the post type!',
        ]);

        $input = $request->all();

        $campaign_id = $input['campaign_id'];
        $user_id = $input['user_id'];

        //$asset = Asset::create($input);
        $asset = new Asset();

        $asset->asset_status_id = AssetStatus::where('name', 'New')->first()->id;
        $asset->content_type = $input['content_type'];
        $asset->file_type = $input['file_type'];
        $asset->user_id = $input['user_id'];
        $asset->campaign_id = $input['campaign_id'];
        $asset->caption = $input['caption'];

        $asset->save();


        if($request->file())
        {
            $name = $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $name, 'public');

            $asset->file = '/storage/' . $filePath;
            $asset->save();
        }

        return redirect()->route('campaigns.show', [$campaign_id, $user_id])
            ->with('message','Asset has been created successfully');
    }

    /* Open view to edit existing asset */
    public function edit(Request $request, $id, $c_id, $u_id)
    {
        $asset = Asset::find($id);

        if(!$asset)
            return abort(404);

        $campaign = Campaign::find($c_id);
        $user = User::find($u_id);

        return view('assets.edit',compact('asset', 'campaign', 'user'));
    }

    /* Update data for a existing asset */
    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'caption' => 'required|min:3',
            'file' => 'mimetypes:image/jpeg,image/png,video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ],
        [
            'caption.required' => 'You have to write caption!',
        ]);

        $asset = Asset::find($id);

        $campaign_id = $asset->campaign_id;
        $user_id = $asset->user_id;

        $asset->update($request->all());

        if($request->file())
        {
            $name = $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $name, 'public');

            $asset->file = '/storage/' . $filePath;
            $asset->save();
        }

        return redirect()->route('campaigns.showMemberAssets', [$campaign_id, $user_id])
            ->with('message','Asset has been created successfully');
    }

    /* Delete asset by id */
    public function destroy($id, $cid, $uid)
    {
        $asset = Asset::find($id);

        if(!$asset)
            return abort(404);

        $asset->delete();

        $campaign = Campaign::find($cid);
        $user = User::find($uid);

        return redirect()->route('campaigns.showMemberAssets', [$campaign, $user])
            ->with('success','Asset has been deleted successfully');
    }

    public function show($id, $cid)
    {
        $campaign = Campaign::find($cid);

        if(!$campaign)
            return abort(404);

        $user = Auth::user();

        $asset = Asset::with('status')->where('id', $id)->first();

        if(!$asset)
            return abort(404);

        if(!$asset->canBeOpened())
        {
            abort(403);
        }

        return view('assets.show',compact('asset', 'campaign', 'user'));
    }
}
