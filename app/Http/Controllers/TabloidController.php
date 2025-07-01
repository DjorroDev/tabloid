<?php

namespace App\Http\Controllers;

use App\Models\Tabloid;
use App\Models\TabloidPage;
use Illuminate\Http\Request;

class TabloidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabloid = Tabloid::all();
        return view('index', ['tabloids' => $tabloid]);
        // return response()->json($tabloid);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $tabloid = Tabloid::create(['title' => 'Tabloid baru']);

        $tabloidPage = TabloidPage::create(['tabloid_id' => $tabloid->id, 'page_number' => 1, 'data' => []]);

        return response()->json([
            'error'    => false,
            'message'  => 'Berhasil membuat Tabloid baru. Redirect ke editor..',
            'redirect' => route('tabloid.edit', $tabloid->id),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tabloid $tabloid) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tabloid $tabloid)
    {
        return view('editor', ['tabloid' => $tabloid]);
    }

    public function getAllPages(Tabloid $tabloid)
    {
        $pages = TabloidPage::where('tabloid_id', $tabloid->id)
            ->orderBy('page_number', 'asc')
            ->select(['page_number', 'data'])
            ->get();

        return response()->json($pages);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tabloid $tabloid)
    {
        $pages = $request->data;

        if (is_string($pages)) {
            $pages = json_decode($pages, true);
        }

        foreach ($pages as $pageKey => $layouts) {
            $pageNumber = (int) filter_var($pageKey, FILTER_SANITIZE_NUMBER_INT);

            $tabloidPage = TabloidPage::updateOrCreate(
                [
                    'tabloid_id' => $tabloid->id,
                    'page_number' => $pageNumber
                ],
                [
                    'data' => $layouts,
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tabloid $tabloid)
    {
        //
    }
}
