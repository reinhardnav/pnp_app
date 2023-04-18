<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposals extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'dollar_amount',
        'client_id',
	    'status',
        'sent_at',
        'canva_link',
        'status',
        'signed_at',
        'notes',
	    'token',
	    'tcuploads',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'dollar_amount' => 'float',
        'client_id' => 'integer',
        'sent_at' => 'timestamp',
        'signed_at' => 'timestamp',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function setTcuploadsAttribute($value)
    {
        $attribute_name = "tcuploads";
        $disk = "public";
        $destination_path = "tcuploads";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path, $fileName = null);
    }
}
