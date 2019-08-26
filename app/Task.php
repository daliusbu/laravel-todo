<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_name',
        'task_description',
        'status_id',
        'completed_date',
    ];

    protected $casts = ['completed_date' => 'datetime'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
