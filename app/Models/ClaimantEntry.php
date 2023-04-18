<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimantEntry extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'rank',
        'unit_assignment',
        'claim_type',
        'period_cover',
        'amount',
        'atm_acc_no',
        'entry_by',
        'claim_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'period_cover' => 'date',
        'amount' => 'float',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'entry_by');
    }

}
