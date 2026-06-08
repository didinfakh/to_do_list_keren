<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Laravel</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f4efe6;
            --panel: #fffdf8;
            --accent: #c46a2d;
            --accent-dark: #8f4416;
            --text: #2a241f;
            --muted: #6f655c;
            --done: #3c7a57;
            --border: #e8dac8;
            --danger: #a53d2a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            background:
                radial-gradient(circle at top left, #f9d9b8 0, transparent 28%),
                linear-gradient(135deg, #f4efe6 0%, #efe5d6 100%);
            color: var(--text);
        }

        .container {
            width: min(960px, calc(100% - 32px));
            margin: 40px auto;
        }

        .hero {
            margin-bottom: 24px;
        }

        .hero h1 {
            margin: 0 0 8px;
            font-size: clamp(2rem, 5vw, 3.4rem);
        }

        .hero p {
            margin: 0;
            color: var(--muted);
            max-width: 640px;
            line-height: 1.6;
        }

        .grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 14px 30px rgba(78, 49, 25, 0.08);
        }

        .card h2 {
            margin-top: 0;
            font-size: 1.3rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
        }

        input[type="text"],
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
            font: inherit;
            background: #fff;
            color: var(--text);
            margin-bottom: 14px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            border: 0;
            border-radius: 999px;
            padding: 11px 16px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-secondary {
            background: #efe2d2;
            color: var(--text);
        }

        .btn-danger {
            background: #f6d7cf;
            color: var(--danger);
        }

        .alert {
            margin-bottom: 16px;
            background: #eef8f1;
            border: 1px solid #b8dbc2;
            color: #205537;
            padding: 12px 14px;
            border-radius: 14px;
        }

        .errors {
            margin-bottom: 16px;
            background: #fff1ee;
            border: 1px solid #f1c8bf;
            color: #7d2c1d;
            padding: 12px 14px;
            border-radius: 14px;
        }

        .todo-list {
            display: grid;
            gap: 16px;
        }

        .todo-item {
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px;
            background: #fff;
        }

        .todo-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: start;
            margin-bottom: 12px;
        }

        .todo-title {
            margin: 0;
            font-size: 1.2rem;
        }

        .todo-title.done {
            text-decoration: line-through;
            color: var(--done);
        }

        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.85rem;
            font-weight: 700;
            background: #f2e3d2;
            color: var(--accent-dark);
        }

        .badge.done {
            background: #dcefe3;
            color: var(--done);
        }

        .todo-description {
            margin: 0 0 16px;
            color: var(--muted);
            line-height: 1.6;
            white-space: pre-line;
        }

        .actions,
        .inline-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .edit-box {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px dashed var(--border);
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            color: var(--muted);
        }

        .empty-state {
            text-align: center;
            padding: 32px 20px;
            border: 1px dashed var(--border);
            border-radius: 18px;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            .container {
                margin: 24px auto;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .todo-top {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <h1>Todo List Laravel</h1>
            <p>Catat pekerjaan harianmu, tandai yang selesai, lalu rapikan daftar tugas dalam satu halaman sederhana berbasis Laravel dan MySQL.</p>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid">
            <section class="card">
                <h2>Tambah Tugas</h2>
                <form method="POST" action="{{ route('todos.store') }}">
                    @csrf
                    <label for="title">Judul</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Belajar Laravel" required>

                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" placeholder="Tambahkan catatan singkat...">{{ old('description') }}</textarea>

                    <button class="btn-primary" type="submit">Simpan Tugas</button>
                </form>
            </section>

            <section class="card">
                <h2>Daftar Tugas</h2>

                @forelse ($todos as $todo)
                    <article class="todo-item">
                        <div class="todo-top">
                            <div>
                                <h3 class="todo-title {{ $todo->is_completed ? 'done' : '' }}">{{ $todo->title }}</h3>
                                <span class="badge {{ $todo->is_completed ? 'done' : '' }}">
                                    {{ $todo->is_completed ? 'Selesai' : 'Belum selesai' }}
                                </span>
                            </div>
                        </div>

                        <p class="todo-description">{{ $todo->description ?: 'Tidak ada deskripsi.' }}</p>

                        <div class="actions">
                            <form class="inline-form" method="POST" action="{{ route('todos.toggle', $todo) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn-secondary" type="submit">
                                    {{ $todo->is_completed ? 'Batalkan Selesai' : 'Tandai Selesai' }}
                                </button>
                            </form>

                            <form class="inline-form" method="POST" action="{{ route('todos.destroy', $todo) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger" type="submit" onclick="return confirm('Hapus tugas ini?')">Hapus</button>
                            </form>
                        </div>

                        <div class="edit-box">
                            <form method="POST" action="{{ route('todos.update', $todo) }}">
                                @csrf
                                @method('PUT')
                                <label for="title-{{ $todo->id }}">Edit Judul</label>
                                <input id="title-{{ $todo->id }}" type="text" name="title" value="{{ $todo->title }}" required>

                                <label for="description-{{ $todo->id }}">Edit Deskripsi</label>
                                <textarea id="description-{{ $todo->id }}" name="description">{{ $todo->description }}</textarea>

                                <label class="checkbox" for="is-completed-{{ $todo->id }}">
                                    <input id="is-completed-{{ $todo->id }}" type="checkbox" name="is_completed" value="1" {{ $todo->is_completed ? 'checked' : '' }}>
                                    Tandai sebagai selesai
                                </label>

                                <button class="btn-primary" type="submit">Update Tugas</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        Belum ada tugas. Tambahkan tugas pertamamu dari panel sebelah kiri.
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</body>
</html>
