<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'student_course_id', 'invoice_number', 'invoice_date',
        'sub_total', 'discount', 'tax', 'total_amount', 'offer_name', 'status',
    ];

    public function installments()
    {
        return $this->hasMany(InvoiceInstallment::class, 'invoice_id');
    }
}
