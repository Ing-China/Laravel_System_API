<?php

namespace App\Http\Controllers;

use App\Models\BookType;
use Illuminate\Http\Request;

class BookTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booktypes = BookType::all();
        return view('backend.booktypes.index', compact('booktypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.booktypes.create');
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

        BookType::create([
            'name' => $request->name,
            'active' => $request->active ?? true,
        ]);

        return redirect()->route('booktypes.index')->with('success', 'Book Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookType $bookTypes)
    {
        // return view('backend.booktypes.show', compact('bookTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookType $bookType)
    {
        // return view('backend.booktypes.edit', compact('bookTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookType $bookType)
    {
        $request->validate([
            'name' => 'required|string|unique:book_types,name,' . $bookType->id,
            'active' => 'boolean',
        ]);

        $bookType->update([
            'name' => $request->name,
            'active' => $request->active,
        ]);

        return redirect()->route('booktypes.index')->with('success', 'Book Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookType $bookType)
    {

        $bookType->delete(); // Perform the delete


        return redirect()->route('booktypes.index')->with('success', 'Book Type deleted successfully.');
    }


    public function updateActive(Request $request, $id)
    {
        $bookType = BookType::findOrFail($id);
        $bookType->active = $request->active;
        $bookType->save();

        return response()->json(['success' => 'Book type status updated successfully.']);
    }
}
