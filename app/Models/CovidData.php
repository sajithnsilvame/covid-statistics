<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovidData extends Model
{
    protected $fillable = ['id','total_cases','deaths','recoveries'];
    protected $table = 'covid_data';
    use HasFactory;
}
