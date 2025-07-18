<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviewer; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth;

class ReviewersController extends Controller
{
    /**
     * Show the form for creating a new reviewer.
     */

    public function index()
     {
         // Get the logged-in customer's id
         $customerId = Auth::id();
 
         // Fetch reviewers that belong to the authenticated customer
         $reviewers = Reviewer::where('cus_id', $customerId)->get();
 
         // Pass the reviewers data to the view
         return view('reviewers', compact('reviewers'));
     }

    public function create()
    {
        return view('add-reviewer'); // Assuming you have a view named 'add-reviewer'
    }

    /**
     * Store a newly created reviewer in the database.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'email' => 'required|email|unique:reviewers,email', // Ensure the email is unique in the reviewers table
            'password' => 'required|min:6', // Ensure the password has at least 6 characters
        ]);

        // Create a new reviewer
        $reviewer = new Reviewer();
        $reviewer->email = $validatedData['email'];
        $reviewer->password = Hash::make($validatedData['password']); // Hash the password for security

        // Store the authenticated customer's ID (cus_id)
        $reviewer->cus_id = Auth::id(); // Assuming the customer is logged in

        // Save the reviewer data to the database
        $reviewer->save();

        // Redirect to a success page or return a success message
        return redirect()->back()->with('success', 'Reviewer added successfully.');
    }

    public function edit($id)
    {
        // Find the reviewer by ID
        $reviewer = Reviewer::findOrFail($id);

        // Return the edit view with the reviewer data
        return view('edit-reviewer', compact('reviewer'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'email' => 'required|email|unique:reviewers,email,' . $id, // Ensure the email is unique, but ignore the current reviewer's email
            'password' => 'nullable|min:6', // Password is optional, but must be at least 6 characters if provided
        ]);

        // Find the reviewer by ID
        $reviewer = Reviewer::findOrFail($id);
        
        // Update the email
        $reviewer->email = $validatedData['email'];

        // Check if a password is provided, and hash it if necessary
        if (!empty($validatedData['password'])) {
            $reviewer->password = Hash::make($validatedData['password']); // Hash the password for security
        }

        // Update the authenticated customer's ID (if needed)
        $reviewer->cus_id = Auth::id(); // Assuming the customer is logged in

        // Save the changes to the database
        $reviewer->save();

        // Redirect to a success page or return a success message
        return redirect()->back()->with('success', 'Reviewer updated successfully.');
    }
}
