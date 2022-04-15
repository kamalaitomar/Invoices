<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();
        return view('products.products', compact('sections', 'products'));
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
        $validated = $request->validate([
            'product_name' => 'bail|required|max:255',
            'section_id' => 'required',
            'description' => 'required',
        ],[

            'product_name.required' =>'يرجى إدخال إسم المنتج', 
            'product_name.unique' =>'إسم المنتج موجود سابقا' ,
            'product_name.max' =>'يرجى إدخال إسم منتج أقل من 255 حرف' ,
            'description.required' =>'يرجى إدخال الوصف ' 
            
        ]);
        
            products::create([
                'product_name' => $request->product_name,
                'section_id' => $request->section_id,
                'description' => $request->description,
            ]);

            session()->flash('Add', 'تم اضافة المنتج بنجاح ');
            return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, products $products)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

       $Products = Products::findOrFail($request->id);

       $Products->update([
       'product_name' => $request->product_name,
       'description' => $request->description,
       'section_id' => $id,
       ]);

       session()->flash('edit', 'تم تعديل المنتج بنجاح');
       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, products $products)
    {
        $Product = Products::findOrFail($request->id);
        $Product->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
