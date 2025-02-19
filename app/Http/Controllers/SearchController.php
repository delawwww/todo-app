<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskList;

class SearchController extends Controller
{
    /**
     * Handle search requests
     * 
     * Method ini akan menangani permintaan pencarian untuk tugas dan daftar tugas
     * berdasarkan kata kunci yang diberikan oleh pengguna.
     */
    public function search(Request $request)
    {
        // Mengambil input pencarian dari permintaan
        $query = $request->input('input');

        // Validasi input, memastikan query minimal 3 karakter dan merupakan string
        $request->validate([
            'query' => 'required|string|min:3'
        ]);

        // Pencarian di tabel tasks, mencari data di kolom 'name' atau 'description' yang cocok dengan query
        $taskResults = Task::where('name', 'LIKE', "%{$query}%") // Pencarian berdasarkan nama
            ->orWhere('description', 'LIKE', "%{$query}%") // Atau berdasarkan deskripsi
            ->get(); // Ambil hasil pencarian sebagai koleksi

        // Pencarian di tabel task_lists, mencari data di kolom 'name' yang cocok dengan query
        $taskListResults = TaskList::where('name', 'LIKE', "%{$query}%")
            ->get(); // Ambil hasil pencarian sebagai koleksi

        // Mengembalikan hasil pencarian sebagai respons dalam format JSON
        // Hasil pencarian dibagi menjadi dua kategori: tasks dan task_lists
        return response()->json([
            'tasks' => $taskResults, // Daftar tugas yang ditemukan
            'task_lists' => $taskListResults // Daftar task list yang ditemukan
        ]);
    }
}