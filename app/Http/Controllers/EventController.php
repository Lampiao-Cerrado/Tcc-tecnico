<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class EventController extends Controller
{

    /* ----------------------------------------------------------
     * CONVERTER DATA PT-BR → US (DD/MM/YYYY → YYYY-MM-DD)
     * ---------------------------------------------------------- */
    private function converterData($data)
    {
        if (!$data) return null;

        // Se for no formato brasileiro
        if (strpos($data, '/') !== false) {
            return Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
        }

        // Se já estiver no formato correto
        return $data;
    }

    /* LISTAGEM (JSON para PAINEL ADMIN) */
    public function index()
    {
        if (request()->ajax()) {
            return Event::with('images')
                ->orderBy('event_date', 'desc')
                ->get()
                ->map(function ($e) {
                    return [
                        'id' => $e->id,
                        'title' => $e->title,
                        'description' => $e->description,
                        'event_date' => $e->event_date,
                        'date_br' => $e->event_date ? date('d/m/Y', strtotime($e->event_date)) : '',
                        'active' => $e->active,
                        'image_url' => $e->main_image ? asset('storage/' . $e->main_image) : null,
                    ];
                });
        }

        return redirect()->route('admin.dashboard');
    }


    /* CRIAR */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'main_image' => 'nullable|image|max:2048',
            'gallery' => 'nullable',
            'gallery.*' => 'nullable|image|max:12288',

        ]);

        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->event_date = $request->event_date;

        // 🔥 CONVERTE DD/MM/YYYY → YYYY-MM-DD
        $event->event_date = $this->converterData($request->event_date);

        if ($request->hasFile('main_image')) {
            $event->main_image = $request->file('main_image')
                ->store('eventos', 'public');
        }

        $event->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                EventImage::create([
                    'event_id' => $event->id,
                    'image_path' => $file->store('eventos/galeria', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true]);
    }


    /* EDITAR (JSON para painel) */
    public function edit(Event $event)
    {
        $event->gallery = $event->images->map(fn($i) => asset('storage/' . $i->image_path));
        return response()->json($event);
    }


    /* UPDATE */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'main_image' => 'nullable|image|max:2048',
            'gallery' => 'nullable',
            'gallery.*' => 'nullable|image|max:12288',
        ]);

        $event->update($request->only('title', 'description', 'event_date'));

        if ($request->hasFile('main_image')) {
            if ($event->main_image && Storage::disk('public')->exists($event->main_image)) {
                Storage::disk('public')->delete($event->main_image);
            }

            $event->main_image = $request->file('main_image')
                ->store('eventos', 'public');

            $event->save();
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                EventImage::create([
                    'event_id' => $event->id,
                    'image_path' => $file->store('eventos/galeria', 'public'),
                ]);
            }
        }

        return response()->json(['success' => true]);
    }


    /* DELETE */
    public function destroy(Event $event)
    {
        if ($event->main_image && Storage::disk('public')->exists($event->main_image)) {
            Storage::disk('public')->delete($event->main_image);
        }

        foreach ($event->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $event->delete();

        return response()->json(['success' => true]);
    }


    /* ATIVAR/DESATIVAR */
    public function toggleActive(Event $event)
    {
        $event->active = !$event->active;
        $event->save();

        return response()->json(['success' => true]);
    }
}
