<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @throws \JsonException
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $data = [];

            $req = $request->toArray();
            $start = $req['start'];
            $length = $req['length'];
            $draw = $req['draw'];
            $column_index = $req['order'][0]['column'];
            $column_dir = $req['order'][0]['dir'];
            $search = $req['search']['value'];

            $filter_column = $req['columns'][$column_index]['name'];

            $total = User::whereHas(
                'role', function($q){
                $q->where('name', 'Client');
            }
            )->count();


            $users = User::with('role')
                ->whereHas('role', function($q)
                {
                    $q->where('name', 'Client');
                })
                ->skip($start)
                ->take($length)
                ->orderBy('users.'.$filter_column, $column_dir)
                ->where(function($q) use($search)
                {
                    if($search)
                    {
                        $q->where('users.first_name', 'like', '%'.$search.'%')
                            ->orWhere('users.last_name', 'like', '%'.$search.'%')
                            ->orWhere('users.username', 'like', '%'.$search.'%')
                            ->orWhere('users.email', 'like', '%'.$search.'%');
                    }
                })->get();


            foreach ($users as $user)
            {
                $dt = [];

                $dt[] = $user->id;
                $dt[] = $user->first_name;
                $dt[] = $user->last_name;
                $dt[] = $user->username;
                $dt[] = $user->email;
                $dt[] = $user->role->name;
                $dt[] = $user->created_at;

                $data[] = $dt;
            }

            $response = [
                "draw" => $draw,
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data
            ];

            return json_encode($response, JSON_THROW_ON_ERROR);
        }

        $search = $request->input('search');

        $users = User::with('role')
            ->with('campaigns')
            ->where(function($q) use($search)
            {
                if($search)
                {
                    $q->where('users.first_name', 'like', '%'.$search.'%')
                        ->orWhere('users.last_name', 'like', '%'.$search.'%')
                        ->orWhere('users.username', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%');
                }
            })
            //->orderBy('created_at', 'asc')
            ->sortable()
            ->paginate(10);

        return view('users.index', compact('users', 'search'));
    }

    public function create(Request $request)
    {
        $roles = Role::pluck('name','id')->all();
        return view('users.create', compact('roles'));
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','id')->all();

        return view('users.edit',compact('user','roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255|min:3',
            'last_name' => 'required|max:255|min:3',
            'username' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:255',
            'role_id' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255|min:3',
            'last_name' => 'required|max:255|min:3',
            'username' => 'required|max:255|min:3',
            'email' => 'required|email',
        ]);

        $input = $request->all();

        $user = User::find($id);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->username = $input['username'];
        $user->email = $input['email'];
        $user->role_id = $input['role_id'];

        if(!empty($input['password']))
        {
            $user->password = Hash::make($input['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        if(User::find($id)->delete())
        {
            return redirect()->route('users.index')
                ->with('success','User deleted successfully');
        }
    }
}
