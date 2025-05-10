<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "expenses";
    protected $primary_key = 'id';
    protected $fillable = [
        'name',
        'amount',
        'time',
        'category'
    ];
}
