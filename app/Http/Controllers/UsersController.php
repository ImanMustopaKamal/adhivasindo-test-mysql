<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use App\Models\GroupModel;
use App\Models\UsersGroupModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $users = UsersModel::get();
        
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $data = $request->getContent();
        $value = json_decode($data);
        foreach($value as $key => $item) {
            DB::beginTransaction();

            $id = UsersModel::get();
    
            $users = new UsersModel;
    
            $users->user_id = count($id)+1;
            $users->nama = $item->nama;
            $users->email = $item->email;
            $users->created_at = date('Y-m-d H:i:s');
            $users->updated_at = date('Y-m-d H:i:s');
    
            $users->save();

            foreach($item->group as $idx => $value) {
                $group = new GroupModel;

                $group->user_group_id = $value->group_id;
                $group->nama = $value->name;
                $group->keterangan = $value->name;
                $group->created_at = date('Y-m-d H:i:s');
                $group->updated_at = date('Y-m-d H:i:s');

                $group->save();

                $id = UsersGroupModel::get();

                $usersgroup = new UsersGroupModel;

                $usersgroup->user_group_id = count($id) + 1;
                $usersgroup->user_id = $users->user_id;
                $usersgroup->group_id = $group->user_group_id;
                $usersgroup->created_at = date('Y-m-d H:i:s');
                $usersgroup->updated_at = date('Y-m-d H:i:s');

                $usersgroup->save();

            }
    
            DB::commit();
        }   
    
        return response()->json('User Successfully Created');
    }

    public function show($id)
    {
        $user = UsersModel::join('user_group', 'user.user_id', '=', 'user_group.user_id');
        $user->join('group', 'user_group.group_id', 'group.user_group_id');
        $user->select('user.nama', 'user.email', 'group.nama as nama_group');
        $user->where('user.user_id', $id);
        $user = $user->get();

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $data = $request->getContent();
        $value = json_decode($data);
        
        foreach($value as $key => $item) {
            DB::beginTransaction();

            $users = UsersModel::find($id);
    
            $users->nama = $item->nama;
            $users->email = $item->email;
            $users->created_at = date('Y-m-d H:i:s');
            $users->updated_at = date('Y-m-d H:i:s');
    
            $users->save();

            $user_group_ex = UsersGroupModel::where('user_id', $id)->get();

            foreach($user_group_ex as $key => $val) {
                $group_ex = GroupModel::where('user_group_id', $val->group_id)->delete();
            }

            $ex_usergroup = UsersGroupModel::where('user_id', $id)->delete();

            foreach($item->group as $idx => $value) {
                $group = new GroupModel;

                $group->user_group_id = $value->group_id;
                $group->nama = $value->name;
                $group->keterangan = $value->name;
                $group->created_at = date('Y-m-d H:i:s');
                $group->updated_at = date('Y-m-d H:i:s');

                $group->save();

                $id = UsersGroupModel::get();

                $usersgroup = new UsersGroupModel;

                $usersgroup->user_group_id = count($id) + 1;
                $usersgroup->user_id = $users->user_id;
                $usersgroup->group_id = $group->user_group_id;
                $usersgroup->created_at = date('Y-m-d H:i:s');
                $usersgroup->updated_at = date('Y-m-d H:i:s');

                $usersgroup->save();

            }

            DB::commit();
        }

        return response()->json('User Successfully Updated');
    }

    public function destroy($id)
    {
        $user_ex = UsersModel::where('user_id', $id)->delete();

        $user_group_ex = UsersGroupModel::where('user_id', $id)->get();

            foreach($user_group_ex as $key => $val) {
                $group_ex = GroupModel::where('user_group_id', $val->group_id)->delete();
            }

        $ex_usergroup = UsersGroupModel::where('user_id', $id)->delete();

        return response()->json('User Successfully Deleted');
    }
}
