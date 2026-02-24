<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
    public function edit()
    {
        $settings = Settings::first();

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'base_price'   => 'required|numeric|min:0',
            'extra_fee'    => 'required|numeric|min:0',
            'player_limit' => 'required|integer|min:1',
            'member_discount' => 'required|numeric|min:1',
            'super_member_discount' => 'required|numeric|min:1',
        ]);

        $data['member_discount'] /= 100;
        $data['super_member_discount'] /= 100;
        
        Settings::updateOrCreate(
            ['id' => 1], // altijd 1 settings record
            $data
        );

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Instellingen opgeslagen.');
    }
}
