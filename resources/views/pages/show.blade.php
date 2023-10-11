<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-10">
            <p class="text-2xl">Show post</p>
        </div>

        <div class="text-sm">
            {{ $post['user']->name }} | {{ $post['user']->email }}
        </div>
        <div class="text-2xl">
            {{ $post->title }}
        </div>
        <br>
        <hr>
        <div class="text-lg py-5">
            {{ $post->summary }}
        </div>
        <div class="text-lg">
            {{ $post->body }}
        </div>
    </div>


</x-app-layout>
