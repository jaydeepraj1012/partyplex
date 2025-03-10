<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\VenueType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page with featured venues
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $featuredVenues = Venue::where('is_featured', true)
            ->where('is_approved', true)
            ->where('is_active', true)
            ->with(['venueType', 'amenities'])
            ->withCount('reviews')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $venueTypes = VenueType::all();

        return view('home', compact('featuredVenues', 'venueTypes'));
    }

    /**
     * Show the about page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the contact page
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Process the contact form submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would typically send an email or save to database
        // Mail::to('contact@partyplex.com')->send(new ContactFormSubmission($validated));

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }

    /**
     * Show the terms and conditions page
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Show the privacy policy page
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Show the FAQ page
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        return view('faq');
    }
}
