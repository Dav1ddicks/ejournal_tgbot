@extends('layouts.app')

@section('title', $student->fullName)
@section('header', $student->fullName)

<p>Group: <a href="{{ route('groups.show', $student->group) }}">{{ $student->group->grade }}</a></p>
