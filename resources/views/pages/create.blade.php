<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-10">
            <p class="text-2xl">Create post</p>
        </div>

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg dark:text-red-400" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg dark:text-green-400" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('store.post') }}">
            @csrf
            <div class="mb-6">
                <label for="Title" class="block mb-2 text-sm font-medium text-gray-900">Your
                    title</label>
                <input type="text" name="title" id="title"
                    class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="title">
            </div>

            <div class="mb-6">
                <label for="summary" class="block mb-2 text-sm font-medium text-gray-900">Your
                    Summary</label>
                <textarea id="summary" name="summary" rows="4"
                    class="mt-2 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="summary"></textarea>
            </div>

            <div class="mb-6">
                <label for="body" class="block mb-2 text-sm font-medium text-gray-900">Your
                    Body</label>
                <textarea id="body" name="body" rows="6"
                    class="mt-2 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="body"></textarea>

            </div>

            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add post
            </button>

        </form>


    </div>


</x-app-layout>
