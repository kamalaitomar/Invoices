<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\addInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        $title = "قائمة الفواتير";
        return view('invoices.invoices', compact('invoices','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();

        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_Commission,
            'discount' => $request->discount,
            'value_VAT' => $request->value_VAT,
            'rate_VAT' => $request->rate_VAT,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->section_id,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $this->validate($request,[
             'pic'=> 'required|mimes:pdf,jpg,jpeg,png|max:10000'   
            ],[
                'pic.mimes'=> 'خطأ : تم حفض الفاتورة و لم يتم حفض المرفق لابد ان يكون (pdf,jpg,jpeg,png)'
            ]);

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $invoice_id.'_'.$file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $invoice_id.'_'.$file_name;
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        $user =User::first();
        $user->notify(new addInvoice($invoice_id));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $invoice = invoices::where('id', $id)->first();
       return view('invoices.invoice_status', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $invoice = invoices::where('id',$id)->first();
       $sections = sections::all();
       return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices $invoices)
    {
       $invoice = invoices::findOrFail($request->invoice) ;
       $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_Commission,
            'discount' => $request->discount,
            'value_VAT' => $request->value_VAT,
            'rate_VAT' => $request->rate_VAT,
            'total' => $request->total,
            'note' => $request->note,
        ]);

        $invoice_datails = invoices_details::where('id_Invoice', $request->invoice);
        $invoice_datails->update([
            'id_Invoice' => $request->invoice,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->section_id,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, invoices $invoices)
    {
        $id = $request->invoice_id;
        $invoice = invoices::where('id', $id)->first();
        $attachments = invoices_attachments::where('invoice_id', $id)->first();

        $id_page = $request->id_page;
        
        if (!$id_page == 2) {
            if (!empty($attachments->invoice_number)) {
                Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number);
            }
            $invoice->forceDelete();
            session()->flash('delete_invoice');
            return Redirect('/invoices');
        }else{
            $invoice->Delete();
            session()->flash('archive_invoice');
            return Redirect('/archivedInvoices');
        }
    }


    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }


    public function paid()
    {
        $invoices = invoices::where('value_status', 1)->get();
        $title = "الفواتير المدفوعة";
        return view('invoices.invoices', compact('invoices','title'));
    }
    public function unpaid()
    {
        $invoices = invoices::where('value_status', 2)->get();
        $title = "الفواتير الغير المدفوعة";
        return view('invoices.invoices', compact('invoices','title'));
    }
    public function partial()
    {
        $invoices = invoices::where('value_status', 3)->get();
        $title = "الفواتير المدفوعة جزئيا";
        return view('invoices.invoices', compact('invoices','title'));
    }


    public function print($id)
    {
        $invoice = invoices::where('id', $id)->first();
        $title = "طباعة الفاتورة";
        return view('invoices.print_invoice', compact('invoice','title'));
    }
}
