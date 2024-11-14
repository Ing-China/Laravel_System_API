<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{

    /**
     * SliderController constructor.
     * Apply role-based permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:slider-list|slider-create|slider-edit|slider-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:slider-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:slider-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:slider-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('backend.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
        }

        $slider = new Slider();
        $slider->image = $imagePath;
        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($slider->image && Storage::exists('public/' . $slider->image)) {
                Storage::delete('public/' . $slider->image);
            }

            // Store new image
            $image = $request->file('image');
            $slider->image = $image->store('images', 'public');
        }

        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image && Storage::exists('public/' . $slider->image)) {
            Storage::delete('public/' . $slider->image);
        }

        // Delete the slider record from the database
        $slider->delete();

        // Redirect to the index page with a success message
        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }

    /**
     * Update the status of the slider.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sliders,id',
            'active' => 'required|boolean',
        ]);

        $slider = Slider::find($request->id);
        $slider->active = $request->active;
        $slider->save();

        return response()->json(['message' => 'Status updated successfully!']);
    }

    /**
     * API to get the list of sliders.
     */
    public function apiIndex(Request $request)
    {
        //http://127.0.0.1:8000/api/sliders?limit=1
        $limit = $request->limit ?? 10;
        $sliders = Slider::where('active', 1)->paginate($limit);
        return response()->json($sliders, 200);
    }
}
