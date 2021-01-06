<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
	public function index() {
        onlyAllowReadPermission('general');
		$settings = Setting::get();
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->setting_name] = $setting->setting_value;
        }

		return view('setting.index')->with('setting', $data);
	}

	public function update(Request $request) {
		$inputs = $request->all();

		unset($inputs['_token']);
		unset($inputs['_method']);

        if ($request->file('logo')) {
            @unlink(setting('logo'));
            $inputs['logo'] = uploadImage($request->file('logo'), 'images/logo/');
        }

		foreach ($inputs as $input => $value) {
			$setting = Setting::firstOrCreate([
				'setting_name' => $input
			]);

			if ($setting) {
				$setting->setting_value = $value;
				$setting->save();
			}
		}

        Cache::forget('settings');

		return redirect()->back()->with([
			'info' => 'Settings updated.'
		]);
	}

}
