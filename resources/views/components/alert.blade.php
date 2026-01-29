@props(['type' => 'info'])

@php
    // Mapping des types vers les classes standards Bootstrap 5
    $classes = [
        'success' => 'alert-success', // Vert
        'error'   => 'alert-danger',  // Rouge (Bootstrap utilise 'danger' pour erreur)
        'warning' => 'alert-warning', // Jaune
        'info'    => 'alert-info',    // Bleu
    ];

    // Sélection de la classe, par défaut 'alert-info' si le type n'existe pas
    $alertClass = $classes[$type] ?? $classes['info'];
@endphp

<div class="alert {{ $alertClass }} border-0 shadow-sm mb-4" role="alert">
    {{ $slot }}
</div>
