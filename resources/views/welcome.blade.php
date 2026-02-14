@extends('layouts.app')

@section('title', 'Klubo - Gestión Deportiva')

@section('content')
    <h1>Gestión Deportiva para Clubes Locales</h1>
    <p>
        Bienvenido a <strong>Klubo</strong>, el sistema integral para la gestión de clubes deportivos.
        Nuestra plataforma permite administrar usuarios, roles, equipos, categorías y asistencia a entrenamientos
        de forma segura y eficiente.
    </p>

    <!-- Sección de noticias en la página principal -->
    <section style="padding: 2rem 0; background: #f8fafc;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <h2 style="text-align: center; margin-bottom: 2rem;">📰 Últimas noticias del club</h2>
            
            @php
                $publicNews = \App\Models\NewsPost::with('user')->latest()->take(3)->get();
            @endphp
            
            @if($publicNews->isEmpty())
                <p style="text-align: center; color: #64748b;">Próximamente noticias del club...</p>
            @else
                <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
                    @foreach($publicNews as $post)
                        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <p style="margin: 0; line-height: 1.5;">{{ Str::limit($post->content, 200) }}</p>
                            <div style="color: #64748b; font-size: 0.85rem; margin-top: 1rem;">
                                <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ route('news.index') }}" style="background: #7c3aed; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 6px; display: inline-block;">
                    Ver todas las noticias
                </a>
            </div>
        </div>
    </section>
@endsection