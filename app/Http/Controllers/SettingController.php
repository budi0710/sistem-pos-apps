<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function save(Request $request){
        $setting = Setting::find(1);

        $setting->latitude = $request->latitude;
        $setting->longitude = $request->longitude;
        $setting->radius = $request->radius;
        $setting->name_company = $request->name_company;

        return $setting->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function upload(Request $request){
        $file = $request->file('logo_company');
        
        $data = $request->_data;
        $data = json_decode($data);

        $path = $file->store('company', 'public');

        $setting = Setting::find(1);

        $setting->logo = $path;
        
        return $setting->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }


    public function getData(){
        $data = Setting::find(1)->get();

        return $data[0];
    }
}
