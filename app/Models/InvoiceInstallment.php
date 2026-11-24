<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceInstallment extends Model
{
    protected $table = 'invoice_installments';
    protected $fillable = ['invoice_id', 'installment_date', 'amount', 'is_paid'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
