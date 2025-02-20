<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskList;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Cari tugas berdasarkan nama atau deskripsi
        $tasks = Task::where('name', 'LIKE', "%{$query}%")
                     ->orWhere('description', 'LIKE', "%{$query}%")
                     ->with('list') // Pastikan data list ikut dikembalikan
                     ->get();
    
        // Cari daftar tugas berdasarkan nama
        $taskLists = TaskList::where('name', 'LIKE', "%{$query}%")->get();
    
        return response()->json([
            'tasks' => $tasks,
            'task_lists' => $taskLists
        ]);
    }
    
}
