<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        return view('students.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Group $group)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'mid_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $group->students()->create($data);

        return redirect()->route('groups.show', $group);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'mid_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $student->update($data);

        return redirect()->route('groups.show', $student->group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $group = $student->group;
        $student->delete();
        return redirect()->route('groups.show', $group);
    }
}
