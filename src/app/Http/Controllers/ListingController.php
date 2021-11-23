<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tag;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::active()
            ->with('tags')
            ->latest()
            ->filter(request(['search', 'tag']))
            ->paginate()
            ->withQueryString();
        
        $tags = Tag::orderBy('name')->get();

        return view('listings.index', compact('listings', 'tags'));
    }

    public function show(Listing $listing)
    {
        $listing->load('tags');

        return view('listings.show', compact('listing'));
    }

    public function apply(Request $request, Listing $listing)
    {
        $listing->clicks()->create([
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        return redirect()->to($listing->apply_link);
    }
}
