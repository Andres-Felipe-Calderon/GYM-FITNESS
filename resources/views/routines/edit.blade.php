<!-- resources/views/routines/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Editar Rutina</h1>

    <form action="{{ route('routines.update', $routine->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Necesario para el método PUT -->
        
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $routine->nombre) }}" required>
        </div>
        
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required>{{ old('descripcion', $routine->descripcion) }}</textarea>
        </div>

        <div>
            <label for="parte">Parte del Cuerpo:</label>
            <input type="text" name="parte" value="{{ old('parte', $routine->parte) }}" required>
        </div>

        <div>
            <label for="ejercicios">Ejercicios:</label>
            <input type="text" name="ejercicios[]" value="{{ old('ejercicios', json_decode($routine->ejercicios)) }}">
        </div>

        <button type="submit">Actualizar Rutina</button>
    </form>
@endsection
