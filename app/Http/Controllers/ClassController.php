<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::paginate(10);
         return redirect()->route('students.index');
    }

    public function create()
    {
        return view('classes.create');
    }

public function store(Request $request)
{
    $request->validate([
        'class_name' => 'required|string|max:255',
        'class_code' => 'nullable|string|max:50',
        'description' => 'nullable|string',
    ]);

    ClassModel::create($request->all());

    // ✅ Redirect back to the Students index page
    return redirect()->route('students.index')->with('success', 'Class added successfully!');
}


    public function edit(ClassModel $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'class_code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $class->update($request->all());

        return redirect()->route('students.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();
        return back()->with('success', 'Class deleted.');
    }

    public function list()
{
    $classes = \App\Models\ClassModel::withCount('students')->get();

    $totalClasses = $classes->count();
    $totalStudents = $classes->sum('students_count');
    $topClass = $classes->sortByDesc('students_count')->first()->class_name ?? null;

    $classNames = $classes->pluck('class_name');
    $classCounts = $classes->pluck('students_count');

    return view('classes.list', compact(
        'classes', 'totalClasses', 'totalStudents', 'topClass', 'classNames', 'classCounts'
    ));
}

}
