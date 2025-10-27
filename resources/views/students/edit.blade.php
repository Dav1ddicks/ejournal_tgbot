@extends('layouts.app')

@section('title', isset($student) ? 'Edit Student' : 'Create Student')
@section('header', isset($student) ? 'Edit Student' : 'Create Student')

<form action="{{ isset($student) ? route('students.update', $student) : route('students.store', $group) }}" method="POST">
    @csrf
    @if(isset($student))
        @method('PUT')
    @endif

    <p>
        <label>First Name</label><br>
        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}">
    </p>

    <p>
        <label>Middle Name</label><br>
        <input type="text" name="mid_name" value="{{ old('mid_name', $student->mid_name ?? '') }}">
    </p>

    <p>
        <label>Last Name</label><br>
        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}">
    </p>

    <button type="submit">{{ isset($student) ? 'Update' : 'Create' }}</button>
</form>
