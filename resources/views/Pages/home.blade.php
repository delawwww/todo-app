@extends('layouts.app') <!--Menggunakan layout 'app' yang umum di aplikasi laravel-->

@section('content')<!-- Container utama untuk konten -->
    
    <!-- Memulai kontainer untuk daftar tugas -->
    <div id="content" class="overflow-y-hidden overflow-x-hidden p-3">
        {{-- Periksa apakah tidak ada daftar tugas (taskLists) yang tersedia --}}
        @if ($taskLists->count() == 0)
            <div class="d-flex flex-column align-items-center">
                <p class="fw-bold text-center">Belum ada tugas yang ditambahkan</p>
                <button type="button" class="btn btn-sm d-flex align-items-center gap-2 btn-outline-warning" style="width: fit-content;">
                    <i class="bi bi-plus-square fs-3"></i> Tambah
                </button>
            </div>
        @endif

        <!-- Container untuk daftar tugas -->
        <div id="task-container" class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 100vh;">
            {{-- Iterasi semua daftar tugas (taskLists) --}}
            @foreach ($taskLists as $list)
                <!-- Kartu daftar tugas -->
                <div class="task-list card flex-shrink-0 bg-info" style="max-height: 80vh;">

                    <!--Menampilkan header kartu untuk list tugas-->
                    <div class="card-header bg-light text-secondary d-flex align-items-center justify-content-between">
                        <h4 class="card-title" style="font-size:18px">{{ $list->name }}</h4>

                        <!--Form untuk menghapus list tugas-->
                        <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm p-0">
                                <i class="bi bi-trash fs-5 text-danger"></i>
                            </button>
                        </form>
                    </div>

                    <!--Menampilkan isi tugas dalam list ini-->
                    <div class="card-body bg-light d-flex flex-column gap-2 overflow-x-hidden">
                       @foreach ($tasks->where('list_id', $list->id) as $task)
                            <!-- Kartu tugas -->
                            <div class="task card">
                                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                    <div class="d-flex flex-column justify-content-center gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="fw-bold lh-1 m-0 {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">    
                                            {{ $task->name }}
                                        </a>
                                        <span class="badge text-bg-{{ $task->priorityClass }} badge-pill" style="width: fit-content">
                                            {{ $task->priority }}
                                        </span>
                                    </div>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        @if (!$task->is_completed) 
                                        <button type="submit" class="btn btn-sm p-0">
                                            <i class="bi bi-x-circle text-danger fs-5"></i>
                                        </button>
                                        @endif
                                    </form>
                                </div>
                                <div class="card-body"><!--bagian task card yang mengatur tentang tampilan card menyesuaikan dengan isi deskripsi-->
                                    <p class="card-text text-truncate" style="width:40vh">{{ $task->description }}</p>
                                </div>
                                @if (!$task->is_completed)
                                    <div class="card-footer">
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-info w-100">
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-check fs-5"></i> Selesai
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <!-- Tombol Tambah dalam setiap daftar tugas -->
                        <button type="button" class="btn btn-outline-info mt-2" data-bs-toggle="modal" data-bs-target="#addTaskModal" data-list="{{$list->id}}">
                               <span class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus"></i> Tambah Tugas
                               </span>
                        </button>
                    </div>
                    <!--footer card jumlah tugas yang ada dalam task-->
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <p class="card-text">{{ $list->tasks->count() }} Tugas</p>
                    </div>
                </div>
            @endforeach

            <!--Tombol untuk menambahkan list baru-->
            <button type="button" class="btn btn-outline-info flex-shrink-0" style="width: 18rem; height: fit-content;"
            data-bs-toggle="modal" data-bs-target="#addListModal">
                <span class="d-flex align-items-center justify-content-center">
                <i class="bi bi-plus fs-5"></i>
                Tambah
                </span>
            </button>
        </div>
    </div>

    

    <!-- Script untuk menangani pencarian tugas -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input'); // Input pencarian
            searchInput.addEventListener('input', function () {
                const query = searchInput.value.trim();
    
                if (query.length >= 3) {
                    fetch(`/search?query=${query}`) // Mengirim permintaan pencarian ke server
                        .then(response => response.json())
                        .then(data => {
                            renderSearchResults(data); // Menampilkan hasil pencarian
                        })
                        .catch(error => console.error('Error fetching search results:', error));
                }
            });
    
            function renderSearchResults(data) {
                const container = document.getElementById('content'); // Kontainer untuk tugas
                container.innerHTML = ''; // Menghapus konten lama
    
                if (data.task_lists.length === 0 && data.tasks.length === 0) {
                    container.innerHTML = '<p class="fw-bold text-center">Tidak ada hasil ditemukan</p>';
                    return;
                }
    
                let contentHTML = '<div class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 80vh;">';
    
                // Menampilkan list tugas yang sesuai dengan hasil pencarian
                data.task_lists.forEach(list => {
                    contentHTML += `
                        <div class="card flex-shrink-0 bg-info" style="width: 18rem; max-height: 80vh;">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h4 class="card-title">${list.name}</h4>
                            </div>
                            <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                    `;
    
                    const filteredTasks = data.tasks.filter(task => task.list_id === list.id); // Menyaring tugas sesuai dengan list
                    filteredTasks.forEach(task => {
                        contentHTML += `
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="d-flex flex-column justify-content-center gap-2">
                                        <a href="/tasks/${task.id}" class="fw-bold lh-1 m-0 ${task.is_completed ? 'text-decoration-line-through' : ''}">
                                            ${task.name}
                                        </a>
                                        <span class="badge text-bg-${task.priority}" style="width: fit-content">${task.priority}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-truncate">${task.description ?? ''}</p>
                                </div>
                            </div>
                        `;
                    });
    
                    contentHTML += '</div></div>'; // Menutup div list
                });
    
                contentHTML += '</div>'; // Menutup kontainer utama
                container.innerHTML = contentHTML; // Menampilkan konten yang sudah difilter
            }
        });
    </script>

@endsection