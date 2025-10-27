<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        return response()->json(Language::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:languages,code|max:5',
            'name' => 'required|string',
        ]);

        $language = Language::create($request->only(['code', 'name']));
        return response()->json($language, 201);
    }
}
