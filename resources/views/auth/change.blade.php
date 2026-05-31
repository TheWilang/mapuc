@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cambiar Contraseña</h2>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('change.password') }}">
        @csrf
        <div>
            <label>Contraseña actual</label>
            <input type="password" name="current_password" required>
        </div>
        <div>
            <label>Nueva contraseña</label>
            <input type="password" name="new_password" required>
        </div>
        <div>
            <label>Confirmar nueva contraseña</label>
            <input type="password" name="new_password_confirmation" required>
        </div>
        <button type="submit">Actualizar contraseña</button>
    </form>
</div>
@endsection
