@extends('layouts.app')

@section('title', $group->title. ' клас')
@section('header', $group->title . ' клас')

@section('content')
<h2>Учні <a href="{{ route('groups.students.create', $group) }}">+</a></h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ПІП</th>
        <th>Дії</th>
    </tr>
    @foreach($group->students as $student)
    <tr>
        <td><a href="{{ route('students.show', $student) }}">{{ $student->fullName }}</a></td>
        <td>
            <a href="{{ route('students.edit', $student) }}">Редагувати</a> |
            <a href="{{ route('groups.students.individaul-messages.create', ['group' => $group, 'student' => $student]) }}">Написати повідомлення</a> |
            <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Точно видалити {{ $student->fullName }}')">Видалити</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
