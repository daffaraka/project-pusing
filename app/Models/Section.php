<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    public function parts()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }

    public function subsections()
    {
        return $this->hasMany(Subsection::class);
    }

}
