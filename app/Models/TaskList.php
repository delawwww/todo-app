<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{   //kolom yang bisa di isi atau di ubah(fillable)
    //kolom yang tidak bisa di isi atau diubah(guarded)
    protected $fillable = ['name'];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function tasks() {
        //Digunakan di model yang memiliki banyak model lain (misalnya, User → banyak Post).
        return $this->hasMany(Task::class, 'list_id');
    }
}