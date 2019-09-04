<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        // One-to-One relations
        'user_id',

        // attributes
        'month',
        'gross_amount',
        'net_amount',
        'final_amount',
        'subscription_fee',
        'deduction_amount',
        'employer_deduction_amount',
        'deductions',
        'operations',
        'clients',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function findByUserAndMonth(int $user_id, string $month)
    {
        return static::where('user_id', $user_id)
            ->where('month', $month)
            ->first();
    }
}
