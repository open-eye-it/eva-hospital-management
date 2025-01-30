<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdOperativeNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'ion_id',
        'ipd_id',
        'ion_date',
        'ion_note'
    ];

    public function singlData($ion_id)
    {
        return static::where('ion_id', $ion_id)->first();
    }

    public function insertData($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function updateData($data, $ipd_id)
    {
        return static::where('ipd_id', $ipd_id)->update(\Arr::only($data, $this->fillable));
    }
}
