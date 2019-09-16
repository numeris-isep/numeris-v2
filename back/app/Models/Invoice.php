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
}
