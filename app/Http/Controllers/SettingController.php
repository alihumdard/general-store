<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class SettingController extends Controller
{
    public function index() 
    {
        $settings = Setting::first() ?? new Setting();
        return view('pages.settings', compact('settings'));
    }

    public function updateGeneral(Request $request) 
    {
        $data = $request->validate([
            'pharmacy_name' => 'required|string|max:255',
            'user_name'     => 'required|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'tax_id'        => 'nullable|string|max:100',
            'address'       => 'nullable|string',
            'logo'          => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        try {
            $settings = Setting::first() ?? new Setting();

            if ($request->hasFile('logo')) {
                // Purani image delete karein agar maujood hai
                if ($settings->logo && Storage::disk('public')->exists($settings->logo)) { 
                    Storage::disk('public')->delete($settings->logo); 
                }
                
                // Nayi image store karein
                $path = $request->file('logo')->store('uploads/branding', 'public');
                $settings->logo = $path;
            }

            // Baki data assign karein
            $settings->pharmacy_name = $data['pharmacy_name'];
            $settings->user_name     = $data['user_name'];
            $settings->phone_number  = $data['phone_number'];
            $settings->email         = $data['email'];
            $settings->tax_id        = $data['tax_id'];
            $settings->address       = $data['address'];

            $settings->save();

            return back()->with('success', 'Store settings updated successfully!');

        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}