<?php

namespace App\Http\Controllers;

use App\Models\SettingApp;
use App\Http\Requests\{StoreSettingAppRequest, UpdateSettingAppRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


class SettingAppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:setting app view')->only('index');
        $this->middleware('permission:setting app edit')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingApp = SettingApp::findOrFail(1)->first();
        return view('setting-apps.edit', compact('settingApp'));

    }

    public function update(Request $request, $id)
    {
        Alert::toast('The settingApp was updated successfully.', 'success');
        return redirect()->route('setting-apps.index');
    }

}
