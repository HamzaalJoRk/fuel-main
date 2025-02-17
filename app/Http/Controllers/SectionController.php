<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:sections,name',
        ]);

        Section::create($request->all());
        return redirect()->route('sections.index')->with('success', 'تمت إضافة القسم بنجاح');
    }

    public function show(Section $section)
    {
        return view('sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required|string|unique:sections,name,'.$section->id,
            'manager' => 'required|string',
        ]);

        $section->update($request->all());
        return redirect()->route('sections.index')->with('success', 'تم تحديث بيانات القسم');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'تم حذف القسم');
    }
}
