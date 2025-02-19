<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskList;
 
class Task extends Model //nama file dan nama class task harus sama 
{
    //kolom yang bisa di isi atau di ubah
    protected $fillable = [
        'name',
        'description',
        'is_completed',
        'priority',
        'list_id'
    ];
    //kolom yang dijaga atau yang tidak bisa di isi
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    const PRIORITIES = [
        'low',
        'medium',
        'high'
    ];

    public function getPriorityClassAttribute() {
        return match($this->attributes['priority']) {
            //penjelasan tentang warna dari icon tersebut 
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            default => 'secondary'
        };
    }

    public function list() {
        //satu list ke banyak task (one to many)
        //Digunakan di model yang memiliki foreign key (misalnya, Post → User).
        return $this->belongsTo(TaskList::class, 'list_id');

    }
}