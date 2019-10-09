<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $fillable = [
        // One-to-One relations
        'project_id',

        // attributes
        'gross_amount',
        'vat_amount',
        'final_amount',
        'details',
    ];

    public function generateFilename()
    {
        return sprintf(
            '%s_facture_%s.pdf',
            Carbon::parse($this->project->start_at)->format('Y-m'),
            Str::slug($this->project->name)
        );
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Find invoices by school year
     *
     * Example:
     *      If $year = 2019
     *      Will return invoices->project->startAt >= 2019-01 and < 2020-01
     *
     * @param string $year
     * @return mixed
     */
    public static function findByYear(string $year) {
        $from = Carbon::parse("$year-01-01 00:00:00");
        $to = $from->copy()->addYear();

        return static::whereHas('project', function ($query) use ($from, $to) {
            return $query->whereBetween('start_at', [$from, $to]);
        })->get();
    }
}
