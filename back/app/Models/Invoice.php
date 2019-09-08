<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
