@extends('layouts.app')

@section('title', isset($group) ? 'Edit Group' : 'Create Group')
@section('header', isset($group) ? 'Edit Group' : 'Create Group')

<form action="{{ isset($group) ? route('groups.update', $group) : route('groups.store') }}" method="POST">
    @csrf
    @if(isset($group))
        @method('PUT')
    @endif

    <p>
        <label>Grade</label><br>
        <input type="text" name="grade" value="{{ old('grade', $group->grade ?? '') }}">
    </p>

    <p>
        <label>Sign</label><br>
        <input type="text" name="sign" value="{{ old('sign', $group->sign ?? '') }}">
    </p>

    <p>
        <label>Occupation</label><br>
        <input type="text" name="occupation" value="{{ old('occupation', $group->occupation ?? '') }}">
    </p>

    <button type="submit">{{ isset($group) ? 'Update' : 'Create' }}</button>
</form>
