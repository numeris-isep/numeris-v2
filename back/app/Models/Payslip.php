<?php

namespace App\Models;

use App\Models\Traits\DateQueryTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use DateQueryTrait;

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

    public static function findByUserAndMonth(int $user_id, string $month)
    {
        return static::where('user_id', $user_id)
            ->where('month', $month)
            ->first();
    }

    public static function findByYear(string $year) {
        $from = Carbon::parse("$year-01-01 00:00:00");
        $to = $from->copy()->addYear();

        return static::whereDate('month', [$from, $to])->get();
    }
}
