<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\OrderForms;
use App\Models\Places;
use App\Models\ServiceCategory;
use App\Models\Status;
use App\Models\Candidate;
use App\Models\CompanyManager;
use App\Models\Customer;
use App\Models\History;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CandidateController extends Controller
{
    public function recentOrders(Request $request)
    {

        $userId = Auth::id();
        $customerId = auth()->user()->id;
        $customer = User::select('groups')->find($customerId);
        $gr_ids = [];
        $customerIds = [];
        $colClass=null;
        $company_manager = 0;
        $company_orders = CompanyManager::where('cus_id', $customerId)->first();
        if (!empty($company_orders)) {
            $company_manager = 1;
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

        // Join tables and add additional conditions for recent orders
        $recentOrders = $candidateQuery
            ->leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
            ->leftJoin('places', 'candidates.place', '=', 'places.id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->leftJoin('customers', 'candidates.cus_id', '=', 'customers.id')
            ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('candidates.expired', 0)
            ->select(
                'candidates.*',
                'service_categories.id as service_category_id',
                'service_categories.name as service_category_name',
                'places.name as place_name',
                'customers.name as cus_name',
                'interviews.title as interview_title',
                'statuses.status as status_title',
                'statuses.color as status_color'
            )
            ->orderBy('candidates.created', 'desc')
            ->get();


        $filteredOrders = $recentOrders->filter(function ($candidate) {
            if (in_array($candidate->status, [4, 7, 9, 21, 22])) {
                $history = History::where('order_id', $candidate->id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($history) {
                    $recordDate = Carbon::parse($history->date_time); // Parse the date from history
                    $currentDate = Carbon::now(); // Current date and time

                    // Calculate the difference in days
                    $daysElapsed = $recordDate->diffInDays($currentDate);

                    // Exclude orders that are already archived
                    $daysRemaining = 28 - $daysElapsed;
                    if ($daysRemaining <= 0) {
                        return false; // Exclude this candidate
                    }
                }
            }
            return true; // Include this candidate
        });

        // Count of remaining candidates
        $filteredOrdersCount = $filteredOrders->count();

        // Process each filtered candidate
        $filteredOrders->each(function ($candidate) {
            $daysToArchive = "N/A";

            if (in_array($candidate->status, [4, 7, 21, 22])) {
                $history = History::where('order_id', $candidate->id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($history) {
                    $recordDate = Carbon::parse($history->date_time); // Parse the date from history
                    $currentDate = Carbon::now(); // Current date and time

                    // Calculate the difference in days
                    $daysElapsed = $recordDate->diffInDays($currentDate);

                    // Subtract elapsed days from 28
                    $daysRemaining = 28 - $daysElapsed;

                    if ($daysRemaining > 0) {
                        $daysToArchive = "After " . $daysRemaining . " days";
                    } else {
                        $daysToArchive = "already_archived";
                    }
                }
            }

            // Add the days to archive to the candidate object
            $candidate->days_to_archive = $daysToArchive;
        });
        $recentOrders = $filteredOrders;

        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_status)) {
                        // Fetch the latest status from the 'status' table using the order_id
                        $latestStatus = Status::where('id', $his->last_status)
                            ->select('id', 'status', 'color')
                            ->first(); // Assuming 'status' is the column storing the status

                        // Temporarily set the order's status to the fetched status
                        if ($latestStatus) {

                            $order->status = $latestStatus->id;   // Assign status to status_title
                            $order->status_title = $latestStatus->status;   // Assign status to status_title
                            $order->status_color = $latestStatus->color;    // Assign color to status_color
                        }
                        break;
                    }
                }
            }
        }

        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->staff_id)) {
                        if ($his->staff_id == 1) {
                            $order->staff->name = "N/A";
                        } else {
                            $orderstaff = Staff::where('id', $his->staff_id)
                                ->first();
                            if ($orderstaff) {
                                $order->staff->name = $orderstaff->name;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }

        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_interview_date)) {
                        if ($his->last_interview_date == "0000-00-00") {
                            $order->booked = "Null";   // Assign status to status_title
                        } else {
                            if ($his->last_interview_date == "0000-00-00") {
                                $order->booked = "Null";   // Assign status to status_title
                            } else {
                                $order->booked = $his->last_interview_date;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }
        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_delivery_date)) {
                        if ($his->last_delivery_date == "0000-00-00") {
                            $order->delivery_date = "Null";   // Assign status to status_title
                        } else {
                            if ($his->last_delivery_date == "0000-00-00") {
                                $order->delivery_date = "Null";   // Assign status to status_title
                            } else {
                                $order->delivery_date = $his->last_delivery_date;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }


        $categories = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->select('service_categories.*')
            ->where('customer_services.cus_id', $userId)
            ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.icon','service_categories.created_at', 'service_categories.updated_at')
            ->get();
        $statusString = auth()->user()->statuses;
        $statusIds = array_map('intval', explode(',', $statusString));
        $statuses = Status::whereIn('statuses.id', $statusIds)
            ->leftJoin('status_services', 'statuses.id', '=', 'status_services.status_id')
            ->leftJoin('interviews', 'status_services.service_id', '=', 'interviews.id') // Adjust the join condition based on your schema
            ->select('statuses.*', 'interviews.service_cat_id') // Select desired columns
            ->distinct()
            ->get();

        foreach ($statuses as $row) {
            $row->count = $filteredOrders->where('status', $row->id)->count();
        }
        $history_condition = [];
        if (!empty($gr_ids)) {
            $history_condition = $gr_ids;
        } else {
            if (!empty($customerIds)) {
                $history_condition = $customerIds;
            } else {
                $history_condition = $customerId;
            }
        }
        $history = History::leftJoin('candidates', 'history.order_id', '=', 'candidates.id')
            ->whereIn('candidates.cus_id', $history_condition)
            ->select('history.*') // You can specify the columns you want to select
            ->get();

        if (!empty($gr_ids)) {
            $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
        } else {
            if (!empty($customerIds)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $customerIds);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        }
        $totalOrdersCount = $candidateQuery
            ->where('expired', 0)
            ->count();

        // Get the total history for the authenticated user (expired orders where expired is 1)
        if (!empty($gr_ids)) {
            $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
        } else {
            if (!empty($customerIds)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $customerIds);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        }
        $totalHistoryCount = $candidateQuery
            ->where('expired', 1)
            ->count();

        // Get counts for specific categories based on interview_id where expired is 0
        $interviewCount = Candidate::leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('cus_id', $userId)
            ->where('expired', 0)
            ->where('statuses.status_type', 1) // Interview ID is 1
            ->count();


        $backgroundCheckCount = Candidate::leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('cus_id', $userId)
            ->where('expired', 0)
            ->where('statuses.status_type', 3) // Interview ID is 1
            ->count();

        $followUpCount = Candidate::leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('cus_id', $userId)
            ->where('expired', 0)
            ->where('statuses.status_type', 9) // Interview ID is 1
            ->count();

        $activeCategories = ($interviewCount > 0 ? 1 : 0) +
            ($backgroundCheckCount > 0 ? 1 : 0) +
            ($followUpCount > 0 ? 1 : 0);

        if ($activeCategories === 0) {
            // No active categories, do nothing
        } elseif ($activeCategories === 1) {
            $colClass = "col-md-12"; // Full width
        } elseif ($activeCategories === 2) {
            $colClass = "col-md-6"; // Half width
        } else {
            $colClass = "col-md-4"; // Third width
        }

        $candidates = DB::table('candidates')
            ->join('statuses', 'candidates.status', '=', 'statuses.id')
            ->select(DB::raw("COUNT(*) as count, MONTH(candidates.created) as month, statuses.status_type"))
            ->where('candidates.cus_id', $userId)
            ->where('candidates.expired', 0)
            ->groupBy('month', 'statuses.status_type')
            ->orderBy('month') // Ensure results are ordered by month
            ->get();

        // Create an array to hold the last 12 months (including current month)
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('M')); // Last 12 months labels in correct order
        }

        // Prepare data arrays for the chart
        $interviewsData = array_fill(0, 12, 0); // Initialize interviews data for each month
        $backgroundCheckData = array_fill(0, 12, 0); // Initialize background check data for each month
        $followUpData = array_fill(0, 12, 0); // Initialize follow-up data for each month

        // Loop through each candidate's data
        foreach ($candidates as $candidate) {
            // Validate month is between 1 and 12
            if ($candidate->month < 1 || $candidate->month > 12) {
                continue; // Skip this iteration if month is invalid
            }

            // Get the month difference from the current month
            $monthDiff = Carbon::now()->month - $candidate->month;
            if ($monthDiff < 0) {
                $monthDiff += 12; // Adjust for months in the previous year
            }

            $monthIndex = 11 - $monthDiff; // Convert month difference to index in the last 12 months array

            // Use status_type from the statuses table to categorize the data
            switch ($candidate->status_type) {
                case 1: // Interview category
                    $interviewsData[$monthIndex] += $candidate->count; // Accumulate data for interviews
                    break;
                case 3: // Background Check category
                    $backgroundCheckData[$monthIndex] += $candidate->count; // Accumulate data for background checks
                    break;
                case 9: // Follow-up category
                    $followUpData[$monthIndex] += $candidate->count; // Accumulate data for follow-ups
                    break;
            }
        }


        $interviewStatusCount = [
            'new_order' => 0,
            'pending' => 0,
            'booked' => 0,
            'approved' => 0,
            'denied' => 0,
            'cancel_by_customer' => 0,
        ];

        $backgroundStatusCheckCount = [
            'new_order_background' => 0,
            'pending_background' => 0,
            'consent_sent' => 0,
            'approved_bc' => 0,
            'rebooking' => 0,
            'not_available' => 0,
        ];

        $followUpStatusCount = [
            'New_order_followuppinterview' => 0,
            'pending_msg_follow' => 0,
            'booked_msg_follow' => 0,
            'notshow_msg_follow' => 0,
            'Approved_followup' => 0,
        ];

        $totalOrders = Candidate::leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('cus_id', $userId)
            ->where('expired', 0)
            ->select('candidates.status', 'statuses.status_type', 'statuses.variable')
            ->get();

        $statusTypes = [];
        foreach ($totalOrders as $candidate) {
            $statusTypes[] = $candidate->status_type;
            switch ($candidate->status_type) {
                case 1: // Interviews
                    if (isset($interviewStatusCount[$candidate->variable])) {
                        $interviewStatusCount[$candidate->variable]++;
                    }
                    break;
                case 3: // Background Check
                    if (isset($backgroundStatusCheckCount[$candidate->variable])) {
                        $backgroundStatusCheckCount[$candidate->variable]++;
                    }
                    break;
                case 9: // Follow-Up Interviews
                    if (isset($followUpStatusCount[$candidate->variable])) {
                        $followUpStatusCount[$candidate->variable]++;
                    }
                    break;
                default:
                    logger("Unknown Status Type: {$candidate->status_type}");
                    break;
            }
        }
        $heading_message = Setting::where('id', 5)->first();

        return view('dashboard', compact(
  'recentOrders',
 'totalOrdersCount',
            'filteredOrdersCount',
            'totalHistoryCount',
            'interviewCount',
            'backgroundCheckCount',
            'followUpCount',
            'months',
            'interviewsData',
            'backgroundCheckData',
            'followUpData',
            'activeCategories',
            'company_manager',
            'interviewStatusCount',
            'backgroundStatusCheckCount',
            'followUpStatusCount',
            'colClass',
            'heading_message',
            'history',
            'statuses',
            'categories'
        ));
    }

    public function showOrders(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::id();
        $customerStatuses = explode(',', $user->statuses); // Get allowed statuses for the user


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

        // Join tables and add additional conditions for recent orders
        $orders = $candidateQuery
            ->leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
            ->leftJoin('places', 'candidates.place', '=', 'places.id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('candidates.expired', 0)
            ->select(
                'candidates.*',
                'service_categories.id as service_category_id',
                'service_categories.name as service_category_name',
                'places.name as place_name',
                'interviews.title as interview_title',
                'statuses.status as status_title',
                'statuses.color as status_color'
            )
            ->orderBy('candidates.created', 'desc')
            ->get();

        $recentOrders = $orders;
        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_status)) {
                        // Fetch the latest status from the 'status' table using the order_id
                        $latestStatus = Status::where('id', $his->last_status)
                            ->select('id', 'status', 'color')
                            ->first(); // Assuming 'status' is the column storing the status

                        // Temporarily set the order's status to the fetched status
                        if ($latestStatus) {

                            $order->status = $latestStatus->id;   // Assign status to status_title
                            $order->status_title = $latestStatus->status;   // Assign status to status_title
                            $order->status_color = $latestStatus->color;    // Assign color to status_color
                        }
                        break;
                    }
                }
            }
        }

        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->staff_id)) {
                        if ($his->staff_id == 1) {
                            $order->staff->name = "N/A";
                        } else {
                            $orderstaff = Staff::where('id', $his->staff_id)
                                ->first();
                            if ($orderstaff) {
                                $order->staff->name = $orderstaff->name;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }

        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_interview_date)) {
                        if ($his->last_interview_date == "0000-00-00") {
                            $order->booked = "Null";   // Assign status to status_title
                        } else {
                            if ($his->last_interview_date == "0000-00-00") {
                                $order->booked = "Null";   // Assign status to status_title
                            } else {
                                $order->booked = $his->last_interview_date;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }
        foreach ($recentOrders as $order) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $order->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_delivery_date)) {
                        if ($his->last_delivery_date == "0000-00-00") {
                            $order->delivery_date = "Null";   // Assign status to status_title
                        } else {
                            if ($his->last_delivery_date == "0000-00-00") {
                                $order->delivery_date = "Null";   // Assign status to status_title
                            } else {
                                $order->delivery_date = $his->last_delivery_date;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }

        $categories = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->select('service_categories.*')
            ->where('customer_services.cus_id', $userId)
            ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.icon','service_categories.created_at', 'service_categories.updated_at')
            ->get();
        $statusString = auth()->user()->statuses;
        $statusIds = array_map('intval', explode(',', $statusString));
        $statuses = Status::whereIn('statuses.id', $statusIds)
            ->leftJoin('status_services', 'statuses.id', '=', 'status_services.status_id')
            ->leftJoin('interviews', 'status_services.service_id', '=', 'interviews.id') // Adjust the join condition based on your schema
            ->select('statuses.*', 'interviews.service_cat_id') // Select desired columns
            ->distinct()
            ->get();
        foreach ($statuses as $k => $row) {
            if (!empty($gr_ids)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
            } else {
                if (!empty($customerIds)) {
                    $candidateQuery = Candidate::whereIn('candidates.cus_id', $customerIds);
                } else {
                    $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
                }
            }
            $row->count = $candidateQuery->where('status', $row->id)
                // ->where('cus_id', auth()->user()->id)
                ->where('expired', 0)
                ->count();
        }
        $history_condition = [];
        if (!empty($gr_ids)) {
            $history_condition = $gr_ids;
        } else {
            if (!empty($customerIds)) {
                $history_condition = $customerIds;
            } else {
                $history_condition = $customerId;
            }
        }
        $history = History::leftJoin('candidates', 'history.order_id', '=', 'candidates.id')
            ->whereIn('candidates.cus_id', $history_condition)
            ->select('history.*') // You can specify the columns you want to select
            ->get();
        return view('orders', compact('orders', 'statuses', 'categories'));
    }

    public function filterOrders(Request $request)
    {
        $userId = $request->query('id');
        $orders = Candidate::with(['staff', 'status'])
            ->where('cus_id', $userId)
            ->where('expired', 0)
            ->get();

        return view('orders', compact('orders'));
    }


    public function viewOrder(Request $request)
    {
        $customerId = auth()->user()->id;
        $company_manager = 0;
        $can_view_report = 0;
        $company_orders = CompanyManager::where('cus_id', $customerId)->first();
        if (!empty($company_orders->can_view_report)) {
            $can_view_report = 1;
        }
        if (!empty($company_orders)) {
            $company_manager = 1;
        }

        $userId = $request->query('id');

        $candidate = Candidate::leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
            ->leftJoin('places', 'candidates.place', '=', 'places.id')
            ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('candidates.id', $userId)
            ->select('candidates.*', 'places.name as place_name', 'interviews.title as interview_title', 'statuses.status as status_title', 'statuses.color as status_color')
            ->first();
        if ($candidate) {
            // Fetch the latest history record for the order
            $orderHistory = History::where('order_id', $candidate->id)
                ->get();
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_status)) {
                        // Fetch the latest status from the 'status' table using the order_id
                        $latestStatus = Status::where('id', $his->last_status)
                            ->select('id', 'status', 'color')
                            ->first(); // Assuming 'status' is the column storing the status

                        // Temporarily set the order's status to the fetched status
                        if ($latestStatus) {
                            $candidate->status = $latestStatus->id;   // Assign status to status_title
                            $candidate->status_title = $latestStatus->status;   // Assign status to status_title
                            $candidate->status_color = $latestStatus->color;    // Assign color to status_color
                        }
                        break;
                    }
                }
            }
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->staff_id)) {
                        if ($his->staff_id == 1) {
                            $candidate->staff->name = "N/A";
                        } else {
                            $orderstaff = Staff::where('id', $his->staff_id)
                                ->first();
                            if ($orderstaff) {
                                $candidate->staff->name = $orderstaff->name;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_interview_date)) {
                        if ($his->last_interview_date == "0000-00-00") {
                            $candidate->booked = "Null";   // Assign status to status_title
                        } else {
                            if ($his->last_interview_date == "0000-00-00") {
                                $candidate->booked = "Null";   // Assign status to status_title
                            } else {
                                $candidate->booked = $his->last_interview_date;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
            foreach ($orderHistory as $his) {
                if ($his && strtotime($his->date_time) > time()) {
                    if (!empty($his->last_delivery_date)) {
                        if ($his->last_delivery_date == "0000-00-00") {
                            $candidate->delivery_date = "Null";   // Assign status to status_title
                        } else {
                            if ($his->last_delivery_date == "0000-00-00") {
                                $candidate->delivery_date = "Null";   // Assign status to status_title
                            } else {
                                $candidate->delivery_date = $his->last_delivery_date;   // Assign status to status_title
                            }
                        }
                        break;
                    }
                }
            }
        }

        $form_builder = OrderForms::where(['cus_id' => $candidate->cus_id, 'service_id' => $candidate->interview_id])->first();
        $history = History::where('order_id', $userId)->get();
        if (!$candidate) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $staff = Staff::where('id', $candidate->staff)->first();
        $customer = Customer::where('id', $candidate->cus_id)->select('name', 'email', 'company', 'send_security_report')->get();
        $order_form = OrderForms::where(['cus_id' => $candidate->cus_id, 'service_id' => $candidate->interview_id])->first();
        return view('view-order', compact('candidate', 'staff', 'customer', 'history', 'order_form', 'company_manager', 'form_builder', 'can_view_report'));
    }
    public function editOrder(Request $request)
    {
        $userId = $request->query('id');
        $candidate = Candidate::leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
            ->leftJoin('places', 'candidates.place', '=', 'places.id')
            ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->where('candidates.id', $userId)
            ->select('candidates.*', 'places.name as place_name', 'interviews.title as interview_title', 'statuses.status as status_title', 'statuses.color as status_color')
            ->first();
        if (!$candidate) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $form_builder = OrderForms::where(['cus_id' => $candidate->cus_id, 'service_id' => $candidate->interview_id])->first();
        return view('edit_order', compact('candidate', 'form_builder'));
    }
    public function showDataByStatus(Request $request)
    {

        $statusId = $request->input('status_id');
        $orders = Candidate::leftJoin('interviews', 'candidates.interview_id', '=', 'interviews.id')
            ->leftJoin('places', 'candidates.place', '=', 'places.id')
            ->leftJoin('statuses', 'candidates.status', '=', 'statuses.id')
            ->leftJoin('staff', 'candidates.staff_id', '=', 'staff.id') // Joining staff table
            ->where('candidates.cus_id', auth()->user()->id)
            ->where('candidates.expired', 0)
            ->where('candidates.status', $statusId)
            ->select(
                'candidates.*',
                'places.name as place_name',
                'interviews.title as interview_title',
                'statuses.status as status_title',
                'statuses.color as status_color',
                'staff.name as staff_name'
            ) // Selecting staff name
            ->get();


        return response()->json([
            'data' => $orders,
        ]);
    }

    public function uploadPDF(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        $id = $request->input('id');
        $filename = $request->input('filename') . ".pdf";
        $file = $request->file('file');

        // on live server it is a different path
        $uploadDir = 'http://recway3/security-report-uploads/';

        $file->move(public_path($uploadDir), $filename);

        Candidate::where('id', $id)
            ->update(['basic_investigation_result' => $filename]);

        return response()->json(['message' => 'File uploaded successfully!']);
    }
}