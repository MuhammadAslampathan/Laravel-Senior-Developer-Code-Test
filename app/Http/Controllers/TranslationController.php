<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::with(['language', 'tags']);

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('name', $request->tag));
        }

        if ($request->filled('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }

        if ($request->filled('content')) {
            $query->where('value', 'like', "%{$request->content}%");
        }

        $translations = $query->paginate(50);
        return response()->json($translations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'language_id' => 'required|exists:languages,id',
            'tags' => 'array',
        ]);

        $translation = DB::transaction(function () use ($request) {
            $translation = Translation::create($request->only('key', 'value', 'language_id'));
            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('id', $request->tags)->pluck('id');
                $translation->tags()->sync($tagIds);
            }
            return $translation;
        });

        return response()->json($translation->load('language', 'tags'), 201);
    }

    public function update(Request $request, Translation $translation)
    {
        $request->validate([
            'value' => 'required|string',
            'tags' => 'array',
        ]);

        $translation->update($request->only('value'));

        if ($request->filled('tags')) {
            $tagIds = Tag::whereIn('id', $request->tags)->pluck('id');
            $translation->tags()->sync($tagIds);
        }

        return response()->json($translation->load('language', 'tags'));
    }

    public function export($locale)
    {
        $language = Language::where('code', $locale)->firstOrFail();

        $translations = Translation::where('language_id', $language->id)
            ->select(['key', 'value'])
            ->get()
            ->pluck('value', 'key');

        return response()->json($translations);
    }
}
