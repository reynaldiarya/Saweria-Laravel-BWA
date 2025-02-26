<?php

namespace App\Http\Controllers;

use App\Events\DonationReceived;
use App\Jobs\SendDonationInvoiceMail;
use App\Mail\DonationInvoiceMail;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\InvoiceItem;

class DonationController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY'));
    }

    public function index($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        return view('donation', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'amount' => 'required|integer|min:1000',
            'message' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $donation = Donation::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'amount' => $request->amount,
                'message' => $request->message,
                'status' => 'pending'
            ]);

            $invoiceItems = new InvoiceItem([
                'name' => 'Donation',
                'price' => $request->amount,
                'quantity' => 1
            ]);

            $createInvoice = new CreateInvoiceRequest([
                'external_id' => 'donation_' . $donation->id,
                'amount' => $request->amount,
                'payer_email' => $request->email,
                'invoice_duration' => 172800,
                'items' => [$invoiceItems],
                'success_redirect_url' => route('donation.success', ['id' => $donation->id])
            ]);

            $apiInstance = new InvoiceApi();
            $generateInvoice = $apiInstance->createInvoice($createInvoice);

            $payment = Payment::create([
                'donation_id' => $donation->id,
                'payment_id' => $generateInvoice['id'],
                'payment_method' => 'Xendit',
                'status' => 'pending',
                'payment_url' => $generateInvoice['invoice_url']
            ]);
            
            // SendDonationInvoiceMail::dispatch($donation, $payment);

            Mail::to($donation->email)->queue(new DonationInvoiceMail($donation, $payment));


            DB::commit();


            return redirect()->away($generateInvoice['invoice_url']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function notificationCallback(Request $request)
    {
        $getToken = $request->header('x-callback-token');
        $callbackToken = env('XENDIT_CALLBACK_TOKEN');

        if (!$callbackToken || $getToken !== $callbackToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid callback token'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $payment = Payment::where('payment_id', $request->id)->first();

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $payment->update(['status' => $request->status === 'PAID' ? 'completed' : 'failed']);
        
        if ($request->status === 'PAID') {
            $payment->donation->update(['status' => 'completed']);
        }

        Mail::to($payment->donation->email)->queue(new DonationInvoiceMail($payment->donation, $payment));

        event(new DonationReceived($payment->donation));

        return response()->json([
            'status' => 'success',
            'message' => 'Callback processed successfully'
        ]);
    }
}
