<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomRoleController extends Controller
{
    public function create()
    {
        $rl=AdminRole::whereNotIn('id',[1])->latest()->paginate(config('default_pagination'));
        return view('admin-views.custom-role.create',compact('rl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:admin_roles|max:191',
            'name.0' => 'required',
            'modules'=>'required|array|min:1'
        ],[
            'name.0.required'=>translate('default_data_is_required'),
            'name.required'=>translate('messages.Role name is required!'),
            'modules.required'=>translate('messages.Please select atleast one module')
        ]);

        $role = new AdminRole();
        $role->name = $request->name[array_search('default', $request->lang)];
        $role->modules = json_encode($request['modules']);
        $role->status = 1;
        $role->save();
        $data = [];
        $default_lang = str_replace('_', '-', app()->getLocale());
        foreach ($request->lang as $index => $key) {
            if($default_lang == $key && !($request->name[$index])){
                if ($key != 'default') {
                    array_push($data, array(
                        'translationable_type' => 'App\Models\AdminRole',
                        'translationable_id' => $role->id,
                        'locale' => $key,
                        'key' => 'name',
                        'value' => $role->name,
                    ));
                }
            }else{
                if ($request->name[$index] && $key != 'default') {
                    array_push($data, array(
                        'translationable_type' => 'App\Models\AdminRole',
                        'translationable_id' => $role->id,
                        'locale' => $key,
                        'key' => 'name',
                        'value' => $request->name[$index],
                    ));
                }
            }
        }

        Translation::insert($data);

        Toastr::success(translate('messages.role_added_successfully'));
        return back();
    }

    public function edit($id)
    {
        if($id == 1)
        {
            return view('errors.404');
        }
        $role=AdminRole::withoutGlobalScope('translate')->where(['id'=>$id])->first(['id','name','modules']);
        return view('admin-views.custom-role.edit',compact('role'));
    }

    public function update(Request $request,$id)
    {
        if($id == 1)
        {
            return view('errors.404');
        }
        $request->validate([
            'name' => 'required|max:191|unique:admin_roles,name,'.$id,
            'modules'=>'required|array|min:1',
            'name.0'=>'required',
        ],[
            'name.0.required'=>translate('default_data_is_required'),
            'name.required'=>translate('messages.Role name is required!'),
            'modules.required'=>translate('messages.Please select atleast one module')
        ]);

        $role = AdminRole::find($id);
        $role->name = $request->name[array_search('default', $request->lang)];
        $role->modules = json_encode($request['modules']);
        $role->status = 1;
        $role->save();

        $default_lang = str_replace('_', '-', app()->getLocale());
        foreach ($request->lang as $index => $key) {
            if($default_lang == $key && !($request->name[$index])){
                if ($key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\AdminRole',
                            'translationable_id' => $role->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $role->name]
                    );
                }
            }else{

                if ($request->name[$index] && $key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\AdminRole',
                            'translationable_id' => $role->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $request->name[$index]]
                    );
                }
            }
        }

        Toastr::success(translate('messages.role_updated_successfully'));
        return redirect()->route('admin.users.custom-role.create');
    }
    public function distroy($id)
    {
        if($id == 1)
        {
            return view('errors.404');
        }
        $role=AdminRole::where(['id'=>$id])->delete();
        Toastr::success(translate('messages.role_deleted_successfully'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $rl=AdminRole::where('id','!=','1')
        ->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->latest()->limit(50)->get();
        return response()->json([
            'view'=>view('admin-views.custom-role.partials._table',compact('rl'))->render(),
            'count'=>$rl->count()
        ]);
    }
}
