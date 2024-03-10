<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    protected $table = 'auditors';
    protected $fillable = ['auditor_name', 'auditor_level'];


    public function answers()
    {
        return $this->hasMany(FixAnswer::class);
    }

    public function supp_answers()
    {
        return $this->hasMany(SuppAnswer::class);
    }
}
