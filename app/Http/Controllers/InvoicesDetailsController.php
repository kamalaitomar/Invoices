<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Faker\Core\File;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details, $id)
    {
        $invoice = invoices::findOrFail($id); 
        $invoiceDetails = DB::table('invoices_details')->where('id_invoice', $id)->get();
        $attachments = DB::table('invoices_attachments')->where('invoice_id', $id)->get();

        return view('invoices.invoices_details', compact('invoiceDetails', 'invoice', 'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id, invoices_details $invoices_details)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->invoice_status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->invoice_status,
                'payment_date' => $request->payment_date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section_id,
                'Status' => $request->invoice_status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->invoice_status,
                'payment_date' => $request->payment_date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section_id,
                'Status' => $request->invoice_status,
                'Value_Status' =>3,
                'note' => $request->note,
                'Payment_Date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, invoices_details $invoices_details)
    {
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);

        $attachment = invoices_attachments::findOrFail($request->id_file);
        $attachment->delete();
       
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();  

    }


    public function openFile($invoice_number, $file_name)
    {
        //file is stored under project/public/Attachments/invoice_number/file_name
        $file= public_path(). "/Attachments/$invoice_number/$file_name";
        return response()->file($file);
    }


    public function DownloadFile($invoice_number, $file_name)
    {
        //file is stored under project/public/Attachments/invoice_number/file_name
        $file= public_path(). "/Attachments/$invoice_number/$file_name";
        return response()->download($file);
    }
}
