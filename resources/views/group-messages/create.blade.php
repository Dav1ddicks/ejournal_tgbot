@extends('layouts.app')

@section('title', 'Створити повідомлення')
@section('header', 'Створити повідомлення')

@section('content')
<form action="{{ route('groups.group-messages.store', $group) }}" method="POST">
    @csrf
    

    <p>
        <label>Повідомлення</label><br>
        <input type="text" name="content" value="{{ old('content', '') }}">
    </p>

    <button type="submit">Надіслати</button>
</form>
@endsection