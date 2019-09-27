<?php

namespace App\Models;

use App\Models\Traits\DateQueryTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payslip extends Model
{
    use DateQueryTrait;

    protected $fillable = [
        // One-to-One relations
        'user_id',

        // attributes
        'month',
        'hour_amount',
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

    private function generateFilename(string $type)
    {
        return sprintf(
            '%s_%s_%s.pdf',
            Carbon::parse($this->month)->format('Y-m'),
            $type,
            Str::slug($this->user->getFullName())
        );
    }

    public function generatePayslipName()
    {
        return $this->generateFilename('BV');
    }

    public function generateContractName()
    {
        return $this->generateFilename('contrat');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function findByMonth(string $month)
    {
        return static::where('month', $month)->get();
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
