<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadContent extends Model
{
    use HasFactory;

    protected $table = 'lead_content';
    protected $fillable = [
        'lead_id',
        'content'
    ];

    public function lead()
    {
        return $this->hasOne(Lead::class);
    }
}
