@extends('layouts.admin')

@section('content')
    {{-- Page Heading --}}
    <h1 class="h3 mb-4 text-gray-800">Profile</h1>

    <div class="row">
        {{-- Use a column to constrain the width, matching the theme --}}
        <div class="col-xl-8 col-lg-10">

            {{-- Update Profile Information Card --}}
            <div class="mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password Card --}}
            <div class="mb-4">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account Card --}}
            <div class="mb-4">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
@endsection
