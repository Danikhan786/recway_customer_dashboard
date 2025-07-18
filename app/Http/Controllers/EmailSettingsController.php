<?php

namespace App\Http\Controllers;

use App\Models\AllowedEmails;
use App\Models\Customer;
use App\Models\Interview;
use App\Models\ServiceCategory;
use App\Models\Status;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailSettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $customerStatuses = explode(',', $user->statuses);
        $orders = Candidate::all();

        $categories = ServiceCategory::whereHas('statuses', function ($query) use ($customerStatuses, $user) {
            $query->whereIn('id', $customerStatuses)
                  ->whereIn('status_type', [1, 3, 9])
                  ->whereExists(function ($subQuery) use ($user) {
                      $subQuery->select(DB::raw(1))
                               ->from('allowed_emails')
                               ->whereColumn('allowed_emails.status_id', 'statuses.id')
                               ->where('allowed_emails.cus_id', $user->id)
                               ->where('allowed_emails.allowed', 1);
                  });
        })
        ->with([
            'statuses' => function ($query) use ($customerStatuses, $user) {
                $query->whereIn('id', $customerStatuses)
                      ->with(['allowedEmails' => function ($query) use ($user) {
                          $query->where('cus_id', $user->id);
                      }]);
            }
        ])
        ->get();
        
        
        
        $interviews = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->select('service_categories.*')
            ->where('customer_services.cus_id', $user->id)
            ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.icon')
            ->get();

        return view('email_settings', compact('orders', 'categories', 'customerStatuses', 'interviews'));
    }
    public function allow_email(Request $request)
    {
        $user = Auth::user();

        if (!empty($request->status_id)) {
            $status = $request->status_id;

            // Find existing record
            $notification = AllowedEmails::where('status_id', $status)
                ->where('cus_id', $user->id)
                ->first();

            if ($request->checked == 1) {
                if ($notification) {
                    $notification->update(['allowed' => 1]);
                } else {
                    AllowedEmails::create([
                        'cus_id' => $user->id,
                        'status_id' => $status,
                        'allowed' => 1
                    ]);
                }
            } else {
                if ($notification) {
                    $notification->update(['allowed' => 0]);
                }
            }

        }
        return response()->json(['success' => true, 'message' => 'Email notifications updated successfully.']);
    }
}
