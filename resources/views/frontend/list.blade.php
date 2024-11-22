@extends('frontend.landing')

@section('title', __('Form Aduan'))

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Existing styles */
        .card {
            border: none;
            border-radius: 8px;
            transition: transform 0.3s ease;
            background-color: #f9f9f9;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            color: #555;
            font-size: 1rem;
        }

        .pagination-container {
            margin-top: 20px;
        }

        .pagination {
            display: inline-flex;
            justify-content: center;
            padding-left: 0;
            list-style: none;
            border-radius: 0.375rem;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            border-radius: 50%;
            padding: 10px 15px;
            background-color: #fff;
            border: 1px solid #ccc;
            color: #007bff;
        }

        .pagination .active .page-link {
            background-color: #4caf50;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #e0e0e0;
        }

        .badge {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 5px 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .d-flex {
            display: flex;
            align-items: center;
        }

        .me-2 {
            margin-right: 10px;
        }

        .fa-calendar-alt,
        .fa-user {
            margin-right: 5px;
        }

        .card {
            border: none;
            border-radius: 35px;
            transition: transform 0.3s ease;
            background-color: #f9f9f9;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Suggestion list styles */
        #suggestion-list {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 100;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f1f1f1;
        }
    </style>

    <main class="main">
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0"></h1>
            </div>
        </div>

        <section id="starter-section" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>List Aduan</h2>
                <p>Berikut adalah daftar aduan yang telah dilaporkan. Bersama kita wujudkan lingkungan sekolah yang aman dan
                    nyaman bagi semua.</p>
            </div>
            <div class="container" data-aos="fade-up">
                <!-- Start Search Bar -->
                <div class="row mb-4 position-relative">
                    <div class="col-md-4 ms-auto"> <!-- ms-auto pushes it to the right -->
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" id="search"
                                placeholder="Cari Aduan..." value="" autocomplete="off">
                            <button class="btn btn-primary" type="button"><i class="fas fa-search"></i> Cari</button>
                        </div>
                        <div id="suggestion-list"></div>
                    </div>
                </div>
                <div class="row">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @foreach ($aduans as $aduan)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-start align-items-center mb-3">
                                        <span
                                            class="badge text-white {{ $aduan->type == 'Public' ? 'bg-primary' : 'bg-secondary' }} me-2">
                                            {{ $aduan->type }}
                                        </span>
                                        <span
                                            class="badge text-white
                                            {{ $aduan->status == 'Selesai' ? 'bg-success' : ($aduan->status == 'Ditolak' ? 'bg-danger' : 'bg-secondary') }}">
                                            {{ $aduan->status }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-start mb-3">
                                        <span class="text-muted me-3">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($aduan->created_at)->format('d/m/Y') }}
                                        </span>
                                        <span class="text-muted">
                                            <i class="fas fa-user"></i> {{ $aduan->nama }}
                                        </span>
                                    </div>
                                    <h5 class="card-title">{{ $aduan->judul }}</h5>
                                    <p class="card-text">{{ Str::limit($aduan->keterangan, 100) }}</p>
                                    <a href="{{ route('web.detail', ['id' => $aduan->id]) }}"
                                        class="btn btn-primary btn-sm mt-2">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container text-center mt-4">
                    {{ $aduans->links('pagination::bootstrap-5') }}
                </div>
                <!-- End List Aduan -->
            </div>
        </section>
    </main>

    <script>
        // JavaScript/jQuery for search suggestions
        document.getElementById('search').addEventListener('input', function() {
            let query = this.value;
            if (query.length > 2) { // Only start searching after 3 characters
                fetchSuggestions(query);
            } else {
                document.getElementById('suggestion-list').style.display = 'none';
            }
        });

        function fetchSuggestions(query) {
            fetch('{{ route('aduans.search') }}?query=' + query)
                .then(response => response.json())
                .then(data => {
                    let suggestions = data.suggestions;
                    let suggestionList = document.getElementById('suggestion-list');
                    suggestionList.innerHTML = ''; // Clear previous suggestions

                    suggestions.forEach(suggestion => {
                        let div = document.createElement('div');
                        div.classList.add('suggestion-item');
                        div.textContent = suggestion.judul;
                        div.addEventListener('click', function() {
                            window.location.href = suggestion.url; // Redirect to the clicked suggestion
                        });
                        suggestionList.appendChild(div);
                    });

                    suggestionList.style.display = suggestions.length > 0 ? 'block' : 'none';
                });
        }
    </script>
@endsection
