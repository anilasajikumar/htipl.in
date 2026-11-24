<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceAccountSetting extends Model
{
    protected $table = 'invoice_account_settings';
    protected $fillable = ['account_name', 'account_number', 'bank_name', 'ifsc_code', 'branch', 'qr_image'];
}
