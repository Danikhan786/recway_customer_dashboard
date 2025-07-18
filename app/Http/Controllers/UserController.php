<?php

namespace App\Http\Controllers;

use App\Models\OrderForms;
use App\Models\StandardBillingDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Interview;
use App\Models\Status;
use App\Models\Candidate;

class UserController extends Controller
{
    // Show the edit form
    public function edit()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $categories = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
        ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
        ->select('service_categories.*')
        ->where('customer_services.cus_id', $user->id)
        ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.icon','service_categories.created_at', 'service_categories.updated_at')

        ->get();
    
    $statusString = auth()->user()->statuses;
    $statusIds = array_map('intval', explode(',', $statusString));
    
    $statuses = Status::whereIn('statuses.id', $statusIds)
        ->leftJoin('status_services', 'statuses.id', '=', 'status_services.status_id')
        ->leftJoin('interviews', 'status_services.service_id', '=', 'interviews.id') 
        ->leftJoin('allowed_emails', function ($join) use ($user) {
            $join->on('statuses.id', '=', 'allowed_emails.status_id')
                 ->where('allowed_emails.cus_id', $user->id)
                 ->where('allowed_emails.allowed', 1); // Ensures only allowed statuses are retrieved
        })
        ->select('statuses.*', 'interviews.service_cat_id')
        ->distinct()
        ->get();
    
        foreach ($statuses as $k => $row) {
            $row->count = Candidate::where('status', $row->id)
                ->where('cus_id', auth()->user()->id)
                ->where('expired', 0)
                ->count();
        }
        $form_builder = OrderForms::where(['cus_id' => $user->id])->orderBy('id', 'desc')
            ->first();
            $standard = StandardBillingDetails::where('cus_id', $user->id)->first();
        return view('account', compact('user', 'statuses', 'categories', 'form_builder','standard'));
    }

    // Handle the update logic
    public function update(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update the user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->company = $request->company;
        $user->org_no = $request->org_no;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated data
        $user->save();

        // Redirect back to the account page with a success message
        return redirect()->route('account')->with('success', 'Account updated successfully!');
    }
    public function billing_update(Request $request)
    {
        $user = Auth::user();
        $standard = StandardBillingDetails::where('cus_id', $user->id)->first();
        
        if (!$standard) {
            StandardBillingDetails::create([
                'cus_id' => $user->id, 
                'referenceperson' => $request->referenceperson,
                'reference' => $request->reference,
                'comment' => $request->comment,
            ]);
        } else {
            $standard->update([
                'referenceperson' => $request->referenceperson,
                'reference' => $request->reference,
                'comment' => $request->comment,
            ]);
        }
        return redirect()->back();
    }
}
