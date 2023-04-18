<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
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
        'company_name',
        'phone',
        'email',
	    'upload',
        //'status',
        'nimble_crm_id',

        'created_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        //'status' => 'integer',
        'created_by' => 'integer',
    ];

    public function user()
    {
		return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

	public function setTcuploadsAttribute($value)
	{
		$attribute_name = "tcuploads";
		$disk = "public";
		$destination_path = "tcuploads";
		$this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path, $fileName = null);
	}
}
