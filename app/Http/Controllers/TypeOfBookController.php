<?php

namespace App\Http\Controllers;

use App\Models\TypeOfBook;
use Illuminate\Http\Request;

class TypeOfBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeofbooks = TypeOfBook::all();
        return view('backend.booktypes.index', compact('typeofbooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:book_types,name',
            'active' => 'boolean',
        ]);

        TypeOfBook::create([
            'name' => $request->name,
            'active' => $request->active ?? true,
        ]);

        return redirect()->route('typeofbooks.index')->with('success', 'Book Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeOfBook $typeOfBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeOfBook $typeOfBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeOfBook $typeOfBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeOfBook $typeOfBook)
    {
        $typeOfBook->delete();

        // Redirect to the index page with a success message
        return redirect()->route('typeofbooks.index')->with('success', 'Slider deleted successfully.');
    }
}
