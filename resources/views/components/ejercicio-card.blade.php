<div id="ejercicios" class="mt-4">
    @foreach ($data as $ejercicio)
        <x-ejercicio-card :ejercicio="$ejercicio" />
    @endforeach
</div>
