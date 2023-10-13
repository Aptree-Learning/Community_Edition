@extends('layouts.app')

@section('content')
    <div>
        <header class="flex justify-between bg-white py-6 pl-4 lg:pl-16">
            <div>
                <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">Welcome Back, {{ Auth()->user()->name }}</h1>
            </div>
        </header>

        <div>
            @livewire('my-courses')
        </div>

    </div>
@endsection
