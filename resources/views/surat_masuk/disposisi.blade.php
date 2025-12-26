@extends('layout')

@section('content')
<h4>Disposisi Surat</h4>

<form
    action="{{ route('web.surat-masuk.disposisi.store', $surat->id) }}"
    method="POST"
>
    @csrf

    <div class="mb-3">
        <label class="form-label fw-bold">Disposisikan ke:</label>

        <div class="border rounded p-3" style="max-height: 250px; overflow-y: auto;">
            @foreach ($users as $user)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="users[]"
                        value="{{ $user->id }}"
                        id="user{{ $user->id }}"
                    >
                    <label class="form-check-label" for="user{{ $user->id }}">
                        {{ $user->name }}
                    </label>
                </div>
            @endforeach
        </div>

        @error('users')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary">
        Simpan Disposisi
    </button>

    <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</form>
@endsection
