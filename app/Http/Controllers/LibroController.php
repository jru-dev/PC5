<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LibroController extends Controller
{
    public function index()
    {
        try {
            $libros = DB::connection('oracle')->select(
                "SELECT id, titulo, autor, isbn, categoria, disponible FROM libros ORDER BY titulo"
            );
            
            return view('libros.index', compact('libros'));
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al cargar libros: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('libros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:200',
            'autor' => 'required|max:100',
            'isbn' => 'nullable|max:20',
            'categoria' => 'nullable|max:50'
        ]);

        try {
            DB::connection('oracle')->insert(
                "INSERT INTO libros (titulo, autor, isbn, categoria, disponible) VALUES (?, ?, ?, ?, 1)",
                [
                    $request->input('titulo'),
                    $request->input('autor'),
                    $request->input('isbn'),
                    $request->input('categoria')
                ]
            );

            return redirect()->route('libros.index')->with('success', 'Libro agregado correctamente');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $libro = DB::connection('oracle')->select(
                "SELECT * FROM libros WHERE id = ?", [$id]
            );

            if (empty($libro)) {
                return redirect()->route('libros.index')->withErrors(['error' => 'Libro no encontrado']);
            }

            return view('libros.show', ['libro' => $libro[0]]);
            
        } catch (\Exception $e) {
            return redirect()->route('libros.index')->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $libro = DB::connection('oracle')->select(
                "SELECT * FROM libros WHERE id = ?", [$id]
            );

            if (empty($libro)) {
                return redirect()->route('libros.index')->withErrors(['error' => 'Libro no encontrado']);
            }

            return view('libros.edit', ['libro' => $libro[0]]);
            
        } catch (\Exception $e) {
            return redirect()->route('libros.index')->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|max:200',
            'autor' => 'required|max:100',
            'isbn' => 'nullable|max:20',
            'categoria' => 'nullable|max:50',
            'disponible' => 'required|in:0,1'
        ]);

        try {
            $updated = DB::connection('oracle')->update(
                "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, categoria = ?, disponible = ? WHERE id = ?",
                [
                    $request->input('titulo'),
                    $request->input('autor'),
                    $request->input('isbn'),
                    $request->input('categoria'),
                    $request->input('disponible'),
                    $id
                ]
            );

            return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::connection('oracle')->delete("DELETE FROM libros WHERE id = ?", [$id]);
            
            return redirect()->route('libros.index')->with('success', 'Libro eliminado correctamente');
            
        } catch (\Exception $e) {
            return redirect()->route('libros.index')->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
}