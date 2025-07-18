<?php

namespace App\Http\Controllers;
use App\Models\Candidate;
use App\Models\CompanyManager;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
    
class HistoryController extends Controller
{
    public function index()
    {   
        $userId = Auth::id();
        $customerId = auth()->user()->id;
        $customer = User::select('groups')->find($customerId);
        $gr_ids = [];
        $customerIds = [];
        $company_manager = 0;
        $company_orders = CompanyManager::where('cus_id', $customerId)->first();
        if (!empty($company_orders)) {
            $company_orders = $company_orders->company;
            $customerIds = User::whereRaw('TRIM(company) = ?', [trim($company_orders)])
                ->pluck('id')
                ->toArray();
        }
        if ($customer && !empty($customer->groups)) {
            $groupArr = explode(',', $customer->groups);
        
            // Find all customer IDs with matching groups
            foreach ($groupArr as $group) {
                $groupIds = User::where('groups', 'like', '%' . $group . '%')->pluck('id');
                $gr_ids = array_merge($gr_ids, $groupIds->toArray());
            }
            $gr_ids = array_merge($customerIds, $gr_ids);
            // Remove duplicate IDs, if any
            $gr_ids = array_unique($gr_ids);
        
            // Build the query condition
            if (!empty($gr_ids)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        } else {
            $customerIds[] = $customerId;
            $customerIds = array_unique($customerIds);
            if (!empty($customerIds)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $customerIds);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        }
        $expiredOrders = $candidateQuery
        ->leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
        ->leftJoin('places', 'candidates.place', '=', 'places.id')
        ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
        ->leftJoin('customers', 'candidates.cus_id', '=', 'customers.id') // Add the left join with customers table
        ->where('candidates.expired', 1)
        ->select(
            'candidates.*',
            'places.name as place_name',
            'interviews.title as interview_title',
            'statuses.status as status_title',
            'statuses.color as status_color',
            'customers.company as company_name' // Select company as company_name
        )
        ->get();


        $userId = Auth::id();
        $customerId = auth()->user()->id;
        $customer = User::select('groups')->find($customerId);
        $gr_ids = [];
        $customerIds = [];
        $company_manager = 0;
        $company_orders = CompanyManager::where('cus_id', $customerId)->first();
        if (!empty($company_orders)) {
            $company_orders = $company_orders->company;
            $customerIds = User::whereRaw('TRIM(company) = ?', [trim($company_orders)])
                ->pluck('id')
                ->toArray();
        }
        if ($customer && !empty($customer->groups)) {
            $groupArr = explode(',', $customer->groups);
        
            // Find all customer IDs with matching groups
            foreach ($groupArr as $group) {
                $groupIds = User::where('groups', 'like', '%' . $group . '%')->pluck('id');
                $gr_ids = array_merge($gr_ids, $groupIds->toArray());
            }
            $gr_ids = array_merge($customerIds, $gr_ids);
            // Remove duplicate IDs, if any
            $gr_ids = array_unique($gr_ids);
        
            // Build the query condition
            if (!empty($gr_ids)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        } else {
            $customerIds[] = $customerId;
            $customerIds = array_unique($customerIds);
            if (!empty($customerIds)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $customerIds);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        }

        $recentOrders = $candidateQuery
        ->leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
        ->leftJoin('customers', 'candidates.cus_id', '=', 'customers.id')
        ->leftJoin('places', 'candidates.place', '=', 'places.id')
        ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
        ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
        ->where('candidates.expired', 0)
        ->select(
            'candidates.*',
            'customers.company as company_name',
            'service_categories.id as service_category_id',
            'service_categories.name as service_category_name',
            'places.name as place_name',
            'interviews.title as interview_title',
            'statuses.status as status_title',
            'statuses.color as status_color'
        )
        ->orderBy('candidates.created', 'desc')
        ->get();


            // Identify excluded orders in recentOrders
        $excludedOrders = $recentOrders->filter(function ($candidate) {
        if (in_array($candidate->status, [4, 7,9, 21, 22])) {
            $history = History::where('order_id', $candidate->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($history) {
                $recordDate = Carbon::parse($history->date_time);
                $currentDate = Carbon::now();
                $daysElapsed = $recordDate->diffInDays($currentDate);
                $daysRemaining = 28 - $daysElapsed;

                // Exclude orders that are already archived
                return $daysRemaining <= 0;
            }
        }
        return false;
    });

    // Add excluded orders to expiredOrders
    $expiredOrders = $expiredOrders->merge($excludedOrders);



        return view('history', compact('expiredOrders'));
    }

}
