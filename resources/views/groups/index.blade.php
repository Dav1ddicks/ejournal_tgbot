@extends('layouts.app')

@section('title', 'Класи')
@section('header', 'Список класів')

@section('content')
<h2>Класи <a href="{{ route('groups.create') }}">+</a></h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Клас</th>
        <th>Спеціалізація</th>
        <th>Дії</th>
    </tr>
    @foreach($groups as $group)
    <tr>
        <td><a href="{{ route('groups.show', $group) }}">{{ $group->grade . "-" . $group->sign }}</a></td>
        <td>{{ $group->occupation }}</td>
        <td>
            <a href="{{ route('groups.edit', $group) }}">Редагувати</a> |
            <a href="{{ route('groups.group-messages.create', $group) }}">Надіслати повідомлення</a> |
            <form action="{{ route('groups.destroy', $group) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Точно видалити {{ $group->title }}?')">Видалити</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
