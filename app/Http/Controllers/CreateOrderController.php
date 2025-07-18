<?php

namespace App\Http\Controllers;

use App\Mail\SendCustomEmail;
use App\Models\AllowedEmails;
use App\Models\History;
use App\Models\Places;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Models\Interview;
use App\Models\Candidate;
use App\Models\Customer;
use App\Models\Email;
use App\Models\Messages;
use App\Models\OrderForms;
use App\Models\ServiceCategory;
use App\Models\StandardBillingDetails;
use App\Models\Status;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class CreateOrderController extends Controller
{
    public function index()
    {
        $interviews = Interview::all();
        return view('create_order', compact('interviews'));
    }

    public function view(Request $request)
    {
        $user_id = null;
        if (isset(auth()->user()->id) && !empty(auth()->user()->id)) {
            $user_id = auth()->user()->id;
        }

        $customerId = auth()->user()->id;
        $customer = User::select('groups')->find($customerId);
        $gr_ids = [];

        if ($customer && !empty($customer->groups)) {
            $groupArr = explode(',', $customer->groups);

            // Find all customer IDs with matching groups
            foreach ($groupArr as $group) {
                $groupIds = User::where('groups', 'like', '%' . $group . '%')->pluck('id');
                $gr_ids = array_merge($gr_ids, $groupIds->toArray());
            }

            // Remove duplicate IDs, if any
            $gr_ids = array_unique($gr_ids);

            // Build the query condition
            if (!empty($gr_ids)) {
                $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
            } else {
                $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
            }
        } else {
            $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
        }
        $services = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->select('service_categories.*')
            ->where('customer_services.cus_id', $user_id)
            ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.icon','service_categories.created_at', 'service_categories.updated_at')
            ->get();
        $places = Places::all();
        $totalOrdersCount = $candidateQuery
            ->where('expired', 0)
            ->count();

        // Get the total history for the authenticated user (expired orders where expired is 1)
        if (!empty($gr_ids)) {
            $candidateQuery = Candidate::whereIn('candidates.cus_id', $gr_ids);
        } else {
            $candidateQuery = Candidate::where('candidates.cus_id', $customerId);
        }
        $totalHistoryCount = $candidateQuery
            ->where('expired', 1)
            ->count();
        $standard = StandardBillingDetails::where('cus_id', $user_id)->first();
        $customerdata = User::where('id', $customerId)->first();
        return view('create_order', compact('places', 'services', 'totalOrdersCount', 'totalHistoryCount', 'standard', 'customerdata'));


        // Return the view with interviews data
    }
    public function services()
    {
        $user_id = null;
        if (isset(auth()->user()->id) && !empty(auth()->user()->id)) {
            $user_id = auth()->user()->id;
        }
        $data['services'] = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
            ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
            ->select('service_categories.*')
            ->where('customer_services.cus_id', $user_id)
            ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.icon')
            ->get();
        return view('services', $data);
    }
    function get_services(Request $request)
    {
        $user_id = null;
        if (isset(auth()->user()->id) && !empty(auth()->user()->id)) {
            $user_id = auth()->user()->id;
        }
        $id = $request['ser_id'];
        if (isset($id) && !empty($id)) {
            $interviews = Interview::leftJoin('customer_services', 'interviews.id', '=', 'customer_services.service_id')
                ->leftJoin('service_categories', 'interviews.service_cat_id', '=', 'service_categories.id')
                ->select('interviews.*')
                ->where('customer_services.cus_id', $user_id)
                ->where('interviews.service_cat_id', $id)
                ->groupBy('interviews.id', 'interviews.service_cat_id', 'interviews.title', 'interviews.desc', 'interviews.place', 'interviews.country', 'interviews.cost', 'interviews.delivery_days')
                ->get();
            return response()->json($interviews);
        } else {
            return response()->json([]);
        }
    }
    public function submitOrder(Request $request)
    {
        \Log::info('Order submission initiated.', $request->all());
        $validated = $request->validate([
            'vasc_id' => 'nullable',
            'security' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'pref' => 'nullable',
            'ref' => 'nullable',
            'interview' => 'required|exists:interviews,id',
            'comment' => 'nullable',
            'note' => 'nullable',
            'sendMail' => 'nullable',
            'place' => 'nullable',
            'country' => 'nullable',
            'form_builder' => 'nullable',
        ]);

        try {
            $templateFile = null;
            $files = null;
            $order_ids = Candidate::pluck('order_id')->toArray();
            $uid = $this->generateUniqueOrderId($order_ids);

            $interview = Interview::find($request->interview);

            $statusID = $this->getStatusByServiceCategory($interview->service_cat_id);

            if ($request->hasFile('cv')) {
                $files = $this->uploadFile($request->file('cv'), 'uploads');
            }
            if ($request->hasFile('interview_template')) {
                $templateFile = $this->uploadFile($request->file('interview_template'), 'uploads');
            }
            $meta_info = json_encode([
                'send_email' => $request->sendMail,
                'created_by' => auth()->user()->id,
                'created_on' => now(),
                'user' => 'Customer'
            ]);


            $candidate = Candidate::create([
                'order_id' => $uid,
                'vasc_id' => $request->vasc_id,
                'security' => $request->security,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'place' => $request->place ?? null,
                'country' => $request->country ?? null,
                'cv' => $files,
                'referensperson' => $request->pref,
                'reference' => $request->ref,
                'comment' => $request->comment,
                'note' => $request->note,
                'cus_id' => auth()->user()->id,
                'interview_id' => $request->interview,
                'status' => $statusID,
                'meta_data' => $request->form_builder ? json_encode($request->form_builder) : null,
                'interview_template' => $templateFile,
                'meta_info' => $meta_info,
                'delivery_date' => null,
            ]);

            History::create([
                'order_id' => $candidate->id,
                'desc' => 'Order Created',
                'date_time' => now()
            ]);
            if ($request->sendMail == 'yes') {
                $this->sendEmails($uid, $request);
            }

            return response()->json(['success' => true, 'message' => 'Order submitted successfully!', 'orderId' => $uid, 'keyId' => $candidate->id]);
            ;
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    public function sendEmails($uid, $request)
    {
        $swedenTimezone = new DateTimeZone('Europe/Stockholm');
        $currentDateTime = new DateTime('now', $swedenTimezone);
        $dayOfWeek = $currentDateTime->format('N');
        $currentTime = $currentDateTime->format('H:i:s');
        $startTime = '08:00:00';
        $endTime = '18:00:00';
        $default_message = null;

        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
        } else {
        }

        $name = $request->name . " " . $request->surname;
        $messages = $this->getMessages(auth()->user()->id, $request->interview);
        $default_message = $this->getMessages(0, 0);
        Log::info("cus_message " . $messages);
        if (empty($messages)) {
            $messages = $this->getMessages(0, 0);
        }
        $interview = Interview::where('id', $request->interview)->first();
        $customer = Customer::where('id', auth()->user()->id)->first();
        if (!empty($request->place)) {
            $place = Places::where('id', $request->place)->first();
        }
        $serviceCat = ServiceCategory::where('id', $interview->service_cat_id)->first();

        // customer email sent
        $cus_msg = $interview->service_cat_id == 1 || $interview->service_cat_id == 9 ? $messages->cus_msg : $messages->cus_msg_background;
        Log::info("cus_message " . $cus_msg);
        if (empty($cus_msg)) {
            $cus_msg = $interview->service_cat_id == 1 || $interview->service_cat_id == 9 ? $default_message->cus_msg : $default_message->cus_msg_background;
            Log::info("def_cus_message " . $cus_msg);
        }
        $cusBody = $this->replace($cus_msg, $customer->name, $name, $customer->company, $interview->title, '', '', '', '', '', $uid, '', '', '', $request->vasc_id, $interview->title, !empty($place) ? $place->name : '');
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
            $this->saveEmail("Customer", $customer->name, $uid, 'Customer Message', $cusBody, $customer->email, $serviceCat->name);
            $mailMsg = $this->sendMail($cusBody, $customer->email, $customer->name, $serviceCat->name);
        } else {
            $this->saveEmail("Customer", $customer->name, $uid, 'Customer Message', $cusBody, $customer->email, $serviceCat->name, "1");
        }

        // client email sent
        $statusID = $this->getStatusByServiceCategory($interview->service_cat_id);
        $msg = $this->getStatusMessage($statusID, $interview->id, $customer->id);
        if ($msg) {
            $msg = $msg->col;
        }
        $canBody = $this->replace($msg, $customer->name, $name, $customer->company, $interview->title, '', '', '', '', '', $uid, '', '', '', $request->vasc_id, $interview->title, !empty($place) ? $place->name : '');
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
            $this->saveEmail("Candidate", $name, $uid, 'Candidate Message', $canBody, $request->email, $serviceCat->name);
            $mailMsg = $this->sendMail($canBody, $request->email, $name, $serviceCat->name);
        } else {
            $this->saveEmail("Candidate", $name, $uid, 'Candidate Message', $canBody, $request->email, $serviceCat->name, "1");
        }
        if ($customer->sent_email == 1) {
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
                $this->saveEmail("Customer", $name, $uid, 'CC email of candidate registration', $canBody, $customer->email, $serviceCat->name);
                $mailMsg = $this->sendMail($canBody, $customer->email, $name, $serviceCat->name);
            } else {
                $this->saveEmail("Customer", $name, $uid, 'CC email of candidate registration', $canBody, $customer->email, $serviceCat->name, "1");
            }
        }

        // admin email sent
        $adminBody = $this->replace($messages->admin_msg, $customer->name, $name, $customer->company, $interview->title, '', '', '', '', '', $uid, '', '', '', $request->vasc_id, $interview->title, !empty($place) ? $place->name : '');
        $admin = DB::table('admin')->first();
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
            $this->saveEmail("Admin", $admin->name, $uid, 'Admin Message', $adminBody, $admin->email, 'Order Created');
            $mailMsg = $this->sendMail($adminBody, $admin->email, $admin->name, "Order Created");
        } else {
            $this->saveEmail("Admin", $admin->name, $uid, 'Admin Message', $adminBody, $admin->email, 'Order Created', "1");
        }
    }
    private function generateUniqueOrderId($order_ids)
    {
        $uid = Str::random(6);
        while (in_array($uid, $order_ids)) {
            $uid = Str::random(6);
        }
        return strtoupper($uid);
    }
    private function getStatusByServiceCategory($service_cat_id)
    {
        if ($service_cat_id == 1) {
            return 1;
        } elseif ($service_cat_id == 3) {
            return 13;
        } elseif ($service_cat_id == 9) {
            return 33;
        } elseif ($service_cat_id == 10) {
            return 49;
        }
        return null;
    }
    public function getStatusMessage($status_id, $service_id, $customer_id)
    {
        $statusService = DB::table('status_services')
            ->where('status_id', $status_id)
            ->where('service_id', $service_id)
            ->first();

        if (!empty($statusService)) {
            $interview = DB::table('interviews')
                ->where('id', $service_id)
                ->first();

            if (!empty($interview)) {
                $message = DB::table('messages')
                    ->select($statusService->msg_col . ' as col')
                    ->where('cus_id', $customer_id)
                    ->where('interview_id', $interview->id)
                    ->first();
                return !empty($message) ? $message : false;
            }
        }

        return false;
    }

    public function sendMail($body, $to, $name, $subject, $attachment = null, $delay = false)
    {
        $status = "failed";
        $errorMessage = null;
        $mailMsg = "Email could not be sent.";

        try {
            // Sending the email
            $emailData = new SendCustomEmail($subject, $body, $attachment);
            Mail::to($to)->send($emailData);

            $status = "success";
            $mailMsg = 'Email sent successfully!';
        } catch (Exception $e) {
            // Catching errors during email sending
            $errorMessage = $e->getMessage();
            $mailMsg = "Email could not be sent. Error: {$errorMessage}";
        }

        // Logging email activity to the EmailLogs model
        try {
            \App\Models\EmailLogs::create([
                'meta' => json_encode([
                    "recipient_email" => $to,
                    "recipient_name" => $name,
                    "subject" => $subject
                ]),
                'status' => $status,
                'error_message' => $errorMessage
            ]);
        } catch (Exception $logException) {
            // Log the error in case database insertion fails
            Log::error('Failed to log email activity: ' . $logException->getMessage());
        }

        return $mailMsg;
    }



    public function fetch_form(Request $request)
    {
        $user_id = null;
        if (isset(auth()->user()->id) && !empty(auth()->user()->id)) {
            $user_id = auth()->user()->id;
        }
        $form = null;
        $form = OrderForms::where('cus_id', $user_id)
            ->where('service_id', $request->ser_id)
            ->first();
        return response()->json($form);
    }
    function uploadFile($file, $folder)
    {
        if ($file) {
            $destinationPath = $folder;

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move($destinationPath, $fileName);

            return $fileName;
        }
        return null;
    }
    public function getMessages($cus_id = 0, $service_id = 0)
    {
        $message = Messages::where('cus_id', $cus_id)
            ->where('interview_id', $service_id)
            ->first();

        return $message;
    }
    public function replace($text, $customer = null, $candidate = null, $company = null, $interview = null, $staff = null, $email = null, $password = null, $status = null, $date = null, $orderID = null, $interviewDate = null, $staff_email = null, $comment = null, $vascId = null, $service = null, $place = null)
    {
        if (!empty($customer)) {
            $text = str_replace('{customer}', $customer, $text);
        }
        if (!empty($candidate)) {
            $text = str_replace('{candidate}', $candidate, $text);
        }
        if (!empty($company)) {
            $text = str_replace('{company}', $company, $text);
        }
        if (!empty($interview)) {
            $text = str_replace('{interview}', $interview, $text);
        }
        if (!empty($staff)) {
            $text = str_replace('{staff}', $staff, $text);
        }
        if (!empty($email)) {
            $text = str_replace('{email}', $email, $text);
        }
        if (!empty($password)) {
            $text = str_replace('{password}', $password, $text);
        }
        if (!empty($status)) {
            $text = str_replace('{status}', $status, $text);
        }
        if (!empty($date)) {
            $text = str_replace('{date}', $date, $text);
        }
        if (!empty($orderID)) {
            $text = str_replace('{orderid}', $orderID, $text);
        }
        if (!empty($interviewDate)) {
            $text = str_replace('{interview_date}', $interviewDate, $text);
        }
        if (!empty($staff_email)) {
            $text = str_replace('{staff_email}', $staff_email, $text);
        }
        if (!empty($comment)) {
            $text = str_replace('{comment}', $comment, $text);
        }
        if (!empty($vascId)) {
            $text = str_replace('{vasc_id}', $vascId, $text);
        }
        if (!empty($service)) {
            $text = str_replace('{service}', $service, $text);
        }
        if (!empty($place)) {
            $text = str_replace('{place}', $place, $text);
        }

        return $text;
    }
    public function saveEmail($userType, $userName, $orderID, $msgType, $text, $email, $subject, $email_delay = null)
    {
        Email::create([
            'user_type' => $userType,
            'user_name' => $userName,
            'order_id' => $orderID,
            'msg_type' => $msgType,
            'text' => $text,
            'email' => $email,
            'subject' => $subject,
            'email_delay' => $email_delay,
        ]);
    }
    public function cancel_order(Request $request)
    {
        $request->comment;
        $swedenTimezone = new DateTimeZone('Europe/Stockholm');
        $currentDateTime = new DateTime('now', $swedenTimezone);
        $dayOfWeek = $currentDateTime->format('N');
        $currentTime = $currentDateTime->format('H:i:s');
        $startTime = '08:00:00';
        $endTime = '18:00:00';

        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
        } else {
        }
        $candidate = Candidate::where('id', $request->id)->first();
        if (!$candidate) {
            return back()->with('error', 'Candidate not found.');
        }

        $customer = Customer::where('id', $candidate->cus_id)->first();
        if (!$customer) {
            return back()->with('error', 'Customer not found.');
        }

        $staff = Staff::where('id', $candidate->staff_id)->first();

        $interview = Interview::where('id', $candidate->interview_id)->first();

        if ($interview->service_cat_id == 3) {
            $candidate->status = 40;
            $status = Status::where('id', 40)->first();
        } else if ($interview->service_cat_id == 10) {
            $candidate->status = 56;
            $status = Status::where('id', 56)->first();
        } else {
            $candidate->status = 9;
            $status = Status::where('id', 9)->first();
        }
        $candidate->save();

        if ($candidate->wasChanged('status')) {
            $comment = $request->input('comment') . '<br>-' . auth()->user()->name;

            History::create([
                'order_id' => $candidate->id,
                'desc' => $status->status_detail,
                'date_time' => now(),
                'comment' => $comment
            ]);
        }

        $messages = $this->getMessages($candidate->cus_id, $interview->id);

        if (!empty($staff)) {
            $body = $this->replace($messages->staff_cancel, $customer->name, $candidate->name . " " . $candidate->surname, $customer->company, $interview->title, $staff->name, '', '', '', '', $candidate->order_id, '', '', '', '', $interview->title);

            $this->saveEmail('Staff', $staff->name, $candidate->order_id, 'Order Cancel Staff', $body, $staff->email, 'Order Canceled');
            $this->sendMail($body, $staff->email, $staff->name, 'Order Canceled');
        }
        if ($interview->service_cat_id == 3) {
            $body = $this->replace($messages->bk_can_cancel, $customer->name, $candidate->name, $customer->company, $interview->title, !empty($staff->name) ? $staff->name : '', '', '', '', '', $candidate->order_id, '', '', '', '', $interview->title);
        } else {
            $body = $this->replace($messages->can_cancel, $customer->name, $candidate->name, $customer->company, $interview->title, !empty($staff->name) ? $staff->name : '', '', '', '', '', $candidate->order_id);
        }

        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
            $this->saveEmail('Candidate', $candidate->name . " " . $candidate->surname, $candidate->order_id, 'Order Cancel Candidate', $body, $candidate->email, 'Order Canceled');
            $this->sendMail($body, $staff->email, $staff->name, 'Order Canceled');
        } else {
            $this->saveEmail('Candidate', $candidate->name . " " . $candidate->surname, $candidate->order_id, 'Order Cancel Candidate', $body, $candidate->email, 'Order Canceled', '1');
        }
        return redirect()->route('dashboard')->with('success', 'Order : ' . $candidate->order_id . ' has been canceled successfully');
    }
    public function updateOrder(Request $request)
    {
        $candidate = Candidate::where('id', $request->id)->first();

        // Handle form_builder if exists
        if (!empty($request->form_builder)) {
            $request['form_builder'] = json_encode($request->form_builder);
        } else {
            $request['form_builder'] = null;
        }

        if ($request->hasFile('cv')) {
            $candidate->cv = $this->uploadFile($request->file('cv'), 'uploads');
        }
        if ($request->hasFile('interview_template')) {
            $candidate->interview_template = $this->uploadFile($request->file('interview_template'), 'uploads');
        }
        if ($request['email'] != $candidate->email) {
            $interview = Interview::where('id', $request->interview)->first();
            $customer = Customer::where('id', auth()->user()->id)->first();
            if (!empty($request->place)) {
                $place = Places::where('id', $request->place)->first();
            }
            $serviceCat = ServiceCategory::where('id', $interview->service_cat_id)->first();
            $swedenTimezone = new DateTimeZone('Europe/Stockholm');
            $currentDateTime = new DateTime('now', $swedenTimezone);
            $dayOfWeek = $currentDateTime->format('N');
            $currentTime = $currentDateTime->format('H:i:s');
            $startTime = '08:00:00';
            $endTime = '18:00:00';
            // client email sent
            $statusID = $this->getStatusByServiceCategory($interview->service_cat_id);
            $msg = $this->getStatusMessage($statusID, $interview->id, $customer->id);
            if ($msg) {
                $msg = $msg->col;
            }
            $canBody = $this->replace($msg, $customer->name,$request['name'], $customer->company, $interview->title, '', '', '', '', '', $candidate->order_id, '', '', '', $request->vasc_id, $interview->title, !empty($place) ? $place->name : '');
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
                $this->saveEmail("Candidate",$request['name'], $candidate->order_id, 'Candidate Message', $canBody, $request->email, $serviceCat->name);
                $mailMsg = $this->sendMail($canBody, $request->email,$request['name'], $serviceCat->name);
            } else {
                $this->saveEmail("Candidate",$request['name'], $candidate->order_id, 'Candidate Message', $canBody, $request->email, $serviceCat->name, "1");
            }
        }
        $candidate->name = $request['name'];
        $candidate->surname = $request['surname'];
        $candidate->email = $request['email'];
        $candidate->phone = $request['phone'];
        $candidate->security = $request['security'];
        $candidate->vasc_id = $request['vasc_id'];
        $candidate->referensperson = $request['pref'];
        $candidate->reference = $request['ref'];
        $candidate->comment = $request['comment'];
        $candidate->note = $request['note'];
        $candidate->meta_data = $request['form_builder'];

        if ($candidate->save()) {
            return redirect()->route('viewOrder', ['id' => $request->id])->with('success', 'Candidate updated successfully!');

        }

        return redirect()->back()->with('error', 'Could not update candidate!');
    }
    public function change_status(Request $request)
    {
        $swedenTimezone = new DateTimeZone('Europe/Stockholm');
        $currentDateTime = new DateTime('now', $swedenTimezone);
        $dayOfWeek = $currentDateTime->format('N');
        $currentTime = $currentDateTime->format('H:i:s');
        $startTime = '08:00:00';
        $endTime = '18:00:00';
        $user_id = null;
        if (isset(auth()->user()->id) && !empty(auth()->user()->id)) {
            $user_id = auth()->user()->id;
        }

        $statusId = $request->status;
        $comment = $request->comment;
        $date = date('Y-m-d');
        $canid = $request->id;
        $candidate = Candidate::where('id', $canid)->first();
        $staff = Staff::where('id', $candidate->staff_id)->first();
        $place = Places::where('id', $candidate->place)->first();
        $name = $candidate->name . ' ' . $candidate->surname;
        $customer = Customer::where('id', $candidate->cus_id)->first();
        $interview = Interview::where('id', $candidate->interview_id)->first();
        $serviceCat = ServiceCategory::where('id', $interview->service_cat_id)->first();
        $status_detail = Status::where('id', $statusId)->first();
        $candidate->status = $statusId;
        $candidate->save();
        $comment .= '<br>-' . $user_id;
        History::create([
            'order_id' => $candidate->id,
            'desc' => $status_detail->status_detail,
            'date_time' => now(),
            'comment' => $comment
        ]);
        if (!empty($candidate)) {
            $statusMessage = $this->getStatusMessage($statusId, $candidate->interview_id, $candidate->cus_id);
            if ($statusMessage) {
                $statusMessage = $statusMessage->col;
            }
            if (empty($statusMessage)) {
                $statusMessage = $this->getStatusMessage($statusId, $candidate->interview_id, $candidate->cus_id);
                if ($statusMessage) {
                    $statusMessage = $statusMessage->col;
                }
            }
            $cusBody = $this->replace($statusMessage, $customer->name, $name, $customer->company, $interview->title, !empty($staff) ? $staff->name : '', '', '', $status_detail->status, $date, $candidate->order_id, $date, !empty($staff) ? $staff->email : '', $comment, $candidate->vasc_id, $interview->title, !empty($place) ? $place->name : '');
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
                $this->saveEmail("Customer", $customer->name, $candidate->order_id, 'Customer Message', $cusBody, $customer->email, "Decision has been made by your security department");
                $this->saveEmail("Admin", "Recway", $candidate->order_id, 'CC email to admin of customer message', $cusBody, 'info@recway.se', "Decision has been made by your security department");
                // $this->saveEmail("CC to manager", $customer->name,  $candidate->order_id, 'Customer Message', $cusBody, auth()->user()->email, "Decision has been made by your security department");
            }
            if ($this->isEmailAllowed($candidate->cus_id, $statusId)) {
                $directory = base_path('../../../security-report-uploads/');
                $filename = $candidate->basic_investigation_result;

                if (
                    ($status_detail->variable == "approved" || $status_detail->variable == "denied")
                    && !empty($filename)
                    && file_exists($directory . $filename)
                    && $customer->send_security_report == 1
                ) {
                    // Include file attachment in the email
                    if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
                        $mailMsg = $this->sendMail($cusBody, $customer->email, $customer->name, "Decision has been made by your security department", $directory . $filename);
                        $mailMsg = $this->sendMail($cusBody, 'info@recway.se', "Recway", "Decision has been made by your security department", $directory . $filename);
                        // $mailMsg = $this->sendMail($cusBody, auth()->user()->email, $customer->name, "Decision has been made by your security department", $directory . $filename);
                    } else {
                        $this->saveEmail("Customer", $customer->name, $candidate->order_id, 'Customer Message', $cusBody, $customer->email, "Decision has been made by your security department", "1");
                        $this->saveEmail("Admin", "Recway", $candidate->order_id, 'CC email to admin of customer message', $cusBody, 'info@recway.se', "Decision has been made by your security department", "1");
                        // $this->saveEmail("CC to manager", $customer->name, $candidate->order_id, 'Customer Message', $cusBody, auth()->user()->email, "Decision has been made by your security department", "1");
                    }
                } else {
                    // No file attachment
                    if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && $currentTime >= $startTime && $currentTime <= $endTime) {
                        $mailMsg = $this->sendMail($cusBody, $customer->email, $customer->name, "Decision has been made by your security department");
                        $mailMsg = $this->sendMail($cusBody, 'info@recway.se', "Recway", "Decision has been made by your security department");
                        // $mailMsg = $this->sendMail($cusBody, auth()->user()->email, $customer->name, "Decision has been made by your security department", $directory . $filename);
                    } else {
                        $this->saveEmail("Customer", $customer->name, $candidate->order_id, 'Customer Message', $cusBody, $customer->email, "Decision has been made by your security department", "1");
                        $this->saveEmail("Admin", "Recway", $candidate->order_id, 'CC email to admin of customer message', $cusBody, 'info@recway.se', "Decision has been made by your security department", "1");
                        // $this->saveEmail("CC to manager", $customer->name, $candidate->order_id, 'Customer Message', $cusBody, auth()->user()->email, "Decision has been made by your security department", "1");
                    }
                }
            }

        }
        return redirect()->back();
    }
    function isEmailAllowed($cusId, $statusId)
    {
        $allowedEmail = AllowedEmails::where('cus_id', $cusId)
            ->where('status_id', $statusId)
            ->first();

        return $allowedEmail ? $allowedEmail->allowed != "0" : false;
    }
}
