<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceAccountSetting;
use Illuminate\Http\Request;
use Toastr;

class InvoiceAccountSettingController extends Controller
{
    public function edit()
    {
        $setting = InvoiceAccountSetting::first();
        return view('admin.invoice_account.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = InvoiceAccountSetting::first();
        if (!$setting) {
            $setting = new InvoiceAccountSetting;
        }

        $data = $request->only(['account_name', 'account_number', 'bank_name', 'ifsc_code', 'branch']);

        if ($request->hasFile('qr_image')) {
            $file = $request->file('qr_image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/qr'), $name);
            $data['qr_image'] = 'uploads/qr/' . $name;
        }

        $setting->fill($data)->save();

        Toastr::success('Account Details Updated', 'Success');
        return back()->with('success', 'Account Details Updated');
    }
}
