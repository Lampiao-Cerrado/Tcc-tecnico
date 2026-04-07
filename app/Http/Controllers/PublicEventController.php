<?php

namespace App\Http\Controllers;

use App\Models\Event;

class PublicEventController extends Controller
{
    // Lista pública de eventos (carregamento inicial no Blade)
    public function index()
    {
        $events = Event::where('active', 1)
            ->orderBy('event_date', 'desc')
            ->get();

        return view('site.eventos', compact('events'));
    }

    // API pública para buscar galeria via AJAX
    public function apiShow($id)
    {
        $event = Event::with('images')->where('active', 1)->findOrFail($id);
        return $event;
    }
}
