<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // Palabras prohibidas para filtrado
    private $forbiddenWords = [
        'idiota', 'tonto', 'puta', 'gilipollas', 'imbécil',
        'estúpido', 'capullo', 'mierda', 'joder', 'coño',
        'zorra', 'cabrón', 'polla', 'maricón', 'subnormal'
    ];

    /**
     * Mostrar todas las noticias (público)
     */
    public function index()
    {
        $newsPosts = NewsPost::with('user', 'comments.user')
            ->latest()
            ->paginate(10);

        return view('news.index', compact('newsPosts'));
    }

    /**
     * Crear una nueva noticia (solo admins)
     */
    public function store(Request $request)
    {
        // Verificar que es administrador
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        NewsPost::create([
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Noticia publicada correctamente.');
    }

    /**
     * Añadir un comentario a una noticia
     */
    public function storeComment(Request $request, NewsPost $newsPost)
    {
        $request->validate([
            'content' => 'required|string|max:500'
        ]);

        // Filtrar palabras inapropiadas
        if ($this->containsForbiddenWords($request->content)) {
            return back()->withErrors(['content' => 'El comentario contiene palabras inapropiadas.']);
        }

        Comment::create([
            'news_post_id' => $newsPost->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back();
    }

    /**
     * Dar/quitar like a una noticia
     */
    public function toggleLike(NewsPost $newsPost)
    {
        $user = Auth::user();

        // Verificar si ya dio like
        if ($newsPost->likes()->where('user_id', $user->id)->exists()) {
            // Quitar like
            $newsPost->likes()->detach($user->id);
        } else {
            // Dar like
            $newsPost->likes()->attach($user->id);
        }

        return back();
    }

    /**
     * Verificar si el texto contiene palabras prohibidas
     */
    private function containsForbiddenWords($text)
    {
        $text = strtolower($text);
        foreach ($this->forbiddenWords as $word) {
            if (Str::contains($text, strtolower($word))) {
                return true;
            }
        }
        return false;
    }
}