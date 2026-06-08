<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function index(): View
    {
        return view('todos.index', [
            'todos' => Todo::query()
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Todo::query()->create($validated);

        return back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, Todo $todo): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_completed' => ['nullable', 'boolean'],
        ]);

        $todo->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_completed' => $request->boolean('is_completed'),
        ]);

        return back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function toggle(Todo $todo): RedirectResponse
    {
        $todo->update([
            'is_completed' => ! $todo->is_completed,
        ]);

        return back()->with('success', 'Status tugas berhasil diubah.');
    }

    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}
