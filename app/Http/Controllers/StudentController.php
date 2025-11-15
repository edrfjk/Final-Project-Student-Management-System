<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('classes');

        // Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        if ($request->filled('class')) {
            $query->whereHas('classes', function($q) use ($request) {
                $q->where('classes.id', $request->class);
            });
        }

        $students = $query->paginate(10);
        $classes = ClassModel::all();

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        return view('students.create', compact('classes'));
    }

public function store(Request $request)
{
    // Validate required fields
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'age' => 'required|integer|min:1',
        'year_level' => 'required|integer|between:1,4',
        'class_id' => 'required|exists:classes,id',
        'picture' => 'nullable|image|max:2048',
    ]);

    // Check if email already exists
    if (Student::where('email', $request->email)->exists()) {
        return back()->withInput()->with('error', 'This email is already used by another student.');
    }

    // Create student
    $student = new Student();
    $student->name = $request->name;
    $student->email = $request->email;
    $student->address = $request->address;
    $student->age = $request->age;
    $student->year_level = $request->year_level;

    if ($request->hasFile('picture')) {
        $student->photo = $request->file('picture')->store('students', 'public');
    }

    $student->save();

    // Assign class
    $student->classes()->attach($request->class_id);

    return redirect()->route('students.index')
                     ->with('success', 'Student added successfully!');
}




    public function assignClass(Request $request, Student $student)
    {
        $request->validate([
            // ✅ FIXED: use `class_models` instead of `classes`
            'class_id' => 'required|exists:classes,id',
        ]);

        // Prevent duplicate assignments
        if (!$student->classes()->where('class_id', $request->class_id)->exists()) {
            $student->classes()->attach($request->class_id);
        }

        return back()->with('success', 'Class assigned successfully!');
    }

    public function destroy(Student $student)
{
    // If student has a photo, delete it from storage
    if ($student->photo) {
        \Storage::disk('public')->delete($student->photo);
    }

    // Delete the student record
    $student->delete();

    return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
}

public function edit(Student $student)
{
    $classes = \App\Models\ClassModel::all();
    return view('students.edit', compact('student', 'classes'));
}

public function update(Request $request, Student $student)
{
    $data = $request->validate([
        'picture' => 'nullable|image',
        'name' => 'required|string',
        'email' => 'required|email',
        'address' => 'nullable|string',
        'age' => 'nullable|integer',
        'year_level' => 'nullable|integer',
        'class_id' => 'nullable|exists:classes,id',
    ]);

    // Update photo if provided
    if ($request->hasFile('picture')) {
        if ($student->photo) {
            \Storage::disk('public')->delete($student->photo);
        }
        $data['photo'] = $request->file('picture')->store('students', 'public');
    }

    $student->update($data);

    // Update assigned class if selected
    if ($request->filled('class_id')) {
        $student->classes()->sync([$request->class_id]);
    }

    return redirect()->route('students.index')->with('success', 'Student updated successfully!');
}

public function removeClass(Student $student, $classId)
{
    $student->classes()->detach($classId);
    return back()->with('success', 'Class removed successfully!');
}

public function list()
{
    $totalStudents = \App\Models\Student::count();
    $totalClasses = \App\Models\ClassModel::count();
    $averageAge = \App\Models\Student::avg('age');

    // Students per year level
    $yearStats = \App\Models\Student::selectRaw('year_level, COUNT(*) as count')
        ->groupBy('year_level')
        ->orderBy('year_level')
        ->get();

    $yearLabels = $yearStats->pluck('year_level')->map(fn($y) => "Year $y");
    $yearCounts = $yearStats->pluck('count');

    // Top 5 most populated classes
    $classStats = \DB::table('class_student')
        ->join('classes', 'classes.id', '=', 'class_student.class_id')
        ->select('classes.class_name', \DB::raw('COUNT(class_student.student_id) as total'))
        ->groupBy('classes.class_name')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    $topClassNames = $classStats->pluck('class_name');
    $topClassCounts = $classStats->pluck('total');

    // Determine top year level
    $topYear = $yearStats->sortByDesc('count')->pluck('year_level')->first();

    return view('students.list', compact(
        'totalStudents', 'totalClasses', 'averageAge', 'topYear',
        'yearLabels', 'yearCounts', 'topClassNames', 'topClassCounts'
    ));
}




}
