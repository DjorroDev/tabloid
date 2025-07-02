<?php

namespace App\Http\Controllers;

use App\Models\TabloidTemplate;
use Illuminate\Http\Request;

class TabloidTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $template = TabloidTemplate::all();

        return response()->json($template);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'data' => 'required|json',
        ]);

        if (is_string($validated['data'])) {
            $validated['data'] = json_decode($validated['data'], true);
        }

        $validated['name'] = strtolower($validated['name']);

        TabloidTemplate::updateOrCreate(['name' => $validated['name']], ['data' => $validated['data']]);

        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TabloidTemplate $tabloidTemplate)
    {
        //
    }
}
