@extends('layouts.app')

@section('title', 'Tablón de anuncios - Klubo')

@section('content')
    <h1>📰 Tablón de anuncios</h1>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fee; color: #b91c1c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <!-- Formulario para crear noticias (solo admins) -->
    @auth
        @if(auth()->user()->hasRole('admin'))
            <div style="margin-bottom: 2rem; padding: 1rem; background: #f0fdf4; border-radius: 8px;">
                <h3>➕ Nueva noticia</h3>
                <form method="POST" action="{{ route('news.store') }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <textarea name="content" 
                                  placeholder="Escribe tu noticia aquí..." 
                                  required 
                                  maxlength="1000"
                                  style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; height: 80px;"></textarea>
                    </div>
                    <button type="submit" class="btn" style="background: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                        Publicar noticia
                    </button>
                </form>
            </div>
        @endif
    @endauth

    <!-- Lista de noticias -->
    @if($newsPosts->isEmpty())
        <p>No hay noticias publicadas.</p>
    @else
        @foreach($newsPosts as $post)
            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <!-- Contenido de la noticia -->
                <div style="margin-bottom: 1rem;">
                    <p style="margin: 0; line-height: 1.5;">{{ $post->content }}</p>
                </div>

                <!-- Información del autor y estadísticas -->
                <div style="display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 0.9rem;">
                    <div>
                        <strong>{{ $post->user->name }}</strong> • 
                        {{ $post->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <form method="POST" action="{{ route('news.like.toggle', $post) }}" style="display: inline;">
                            @csrf
                            <button type="submit" 
                                    style="background: none; border: none; cursor: pointer; color: {{ $post->likes->contains(auth()->user()) ? '#dc2626' : '#64748b' }};"
                                    @unless(auth()->check()) disabled @endunless>
                                👍 {{ $post->likes_count }}
                            </button>
                        </form>
                        <span>💬 {{ $post->comments_count }}</span>
                    </div>
                </div>

                <!-- Comentarios -->
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                    @if($post->comments->isEmpty())
                        <p style="color: #94a3b8; font-style: italic;">Sin comentarios</p>
                    @else
                        @foreach($post->comments as $comment)
                            <div style="margin-bottom: 0.5rem; padding: 0.5rem; background: #f8fafc; border-radius: 4px;">
                                <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                                <div style="color: #94a3b8; font-size: 0.8rem;">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Formulario para comentar -->
                    @auth
                        <form method="POST" action="{{ route('news.comments.store', $post) }}" style="margin-top: 1rem;">
                            @csrf
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="text" 
                                       name="content" 
                                       placeholder="Escribe un comentario..." 
                                       maxlength="500"
                                       style="flex: 1; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                <button type="submit" 
                                        class="btn" 
                                        style="background: #059669; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                                    Comentar
                                </button>
                            </div>
                        </form>
                    @else
                        <p style="color: #94a3b8; font-style: italic;">Inicia sesión para comentar</p>
                    @endauth
                </div>
            </div>
        @endforeach

        <!-- Paginación -->
        <div style="margin-top: 2rem;">
            {{ $newsPosts->links() }}
        </div>
    @endif
@endsection