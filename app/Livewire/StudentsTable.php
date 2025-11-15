<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Models\ClassModel;

class StudentsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $year_level = '';
    public $class_id = '';
    public $selected_class = [];

    protected $paginationTheme = 'tailwind';

    // Assign a class to a student
    public function assignClass($studentId)
    {
        $classId = $this->selected_class[$studentId] ?? null;
        if (!$classId) return;

        $student = Student::find($studentId);
        if ($student) {
            $student->classes()->syncWithoutDetaching([$classId]);
        }

        $this->selected_class[$studentId] = '';
    }

    // Remove a class from a student
    public function removeClass($studentId, $classId)
    {
        $student = Student::find($studentId);
        if ($student) {
            $student->classes()->detach($classId);
        }
    }

    // Delete a student
    public function deleteStudent($studentId)
    {
        Student::destroy($studentId);
    }

    // This method will be called by the search button
    public function applyFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $classes = ClassModel::orderBy('class_name')->get();

        $students = Student::with('classes')
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->year_level, fn($query) => $query->where('year_level', $this->year_level))
            ->when($this->class_id, fn($query) => $query->whereHas('classes', fn($q) => $q->where('class_id', $this->class_id)))
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.students-table', [
            'students' => $students,
            'classes' => $classes,
        ]);
    }
}
