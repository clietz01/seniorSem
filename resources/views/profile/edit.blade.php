<x-layout :user="Auth::user()">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Replies</title>
        <link rel="stylesheet" href="{{asset('css/styles.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div>
        <h1>Customize Your Profile</h1>

        @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif

        <form action="{{ secure_url(route('profile.updatePicture'))}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="profile_picture">Upload Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture">
                @error('profile_picture')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <button type="submit">Save</button>
        </form>

        @if (Auth::user()->profile_picture)
            <h3>Current Profile Picture:</h3>
            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" style="max-width: 150px;">
        @endif
    </div>
</x-layout>
