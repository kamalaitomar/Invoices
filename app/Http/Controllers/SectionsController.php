<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();

        return view('sections.sections', compact('sections'));

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
            'section_name' => 'bail|required|unique:sections|max:255',
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجى إدخال إسم القسم', 
            'section_name.unique' =>'إسم القسم موجود سابقا' ,
            'section_name.max' =>'يرجى إدخال إسم قسم أقل من 255 حرف' ,
            'description.required' =>'يرجى إدخال الوصف ' 
            
        ]);
        
            sections::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'created_by' => (Auth::user()->name),
            ]);

            session()->flash('Add', 'تم اضافة القسم بنجاح ');
            return redirect('/sections');        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sections $sections)
    {

        $id =  $request->id;

        $validated = $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجى إدخال إسم القسم', 
            'section_name.unique' =>'إسم القسم موجود سابقا' ,
            'section_name.max' =>'يرجى إدخال إسم قسم أقل من 255 حرف' ,
            'description.required' =>'يرجى إدخال الوصف ' 
            
        ]);

        $section = sections::findOrFail($id);

        $section->section_name = $request->section_name;
        $section->description = $request->description;
        $section->created_by = (Auth::user()->name);

        $section->save();

        

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, sections $sections)
    {
        $id = $request->id;
        $section_name = sections::findOrFail($id)->section_name;
        sections::findOrFail($id)->delete();
        session()->flash('delete','تم حذف قسم '.$section_name.' بنجاج');
        return redirect('/sections');

    }
}
