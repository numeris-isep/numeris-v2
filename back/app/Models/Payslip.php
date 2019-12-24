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
        'signed',
        'paid',
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

    protected $casts = [
        'signed'    => 'boolean',
        'paid'      => 'boolean',
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
        return static::where('month', $month);
    }

    public static function findByUserAndMonth(int $user_id, string $month)
    {
        return static::where('user_id', $user_id)
            ->where('month', $month)
            ->first();
    }

    /**
     * Find payslips by school year
     *
     * Example:
     *      If $year = 2019
     *      Will return payslips->month >= 2019-01 and < 2020-01
     *
     * @param string $year
     * @return mixed
     */
    public static function findByYear(string $year) {
        $from = Carbon::parse("$year-01-01 00:00:00");
        $to = $from->copy()->addYear();

        return static::whereDate('month', [$from, $to])->get();
    }

    public static function findTopThree(string $date) {
        return static::findByMonth($date)
            ->get()
            ->load('user')
            ->sortByDesc('hour_amount')
            ->slice(0, 3);
    }
}
