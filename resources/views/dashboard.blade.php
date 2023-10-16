<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
        {{-- @if (Auth::user()->isAdmin) --}}
        @can('can-add-post')
            <a href="{{ route('create.post') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create post
            </a>
        @endcan
        {{-- @endif --}}
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (Session::has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg dark:text-green-400" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Users
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    @can('can-edit')
                        <th scope="col" class="px-6 py-3" colspan="2">
                            Action
                        </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            {{ $post->id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <a href="{{ route('show.post', $post->id) }}">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            {{ $post['user']->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post['user']->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post['user']->isAdmin == 0 ? 'User' : 'Admin' }}
                        </td>
                        @can('can-edit')
                            <td class="px-6 py-4">
                                {{-- @if (Auth::user()->id == $post->user_id) --}}
                                <a href="{{ route('edit.post', $post->id) }}" style="color: blue">
                                    Edit
                                </a>
                                {{-- @else
                                Edit
                            @endif --}}
                            </td>
                            <td class="px-6 py-4">
                                {{-- @if (Auth::user()->id == $post->user_id) --}}
                                <form action="{{ route('destroy.post', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button style="color: red">
                                        Delete
                                    </button>
                                </form>
                                {{-- @else
                                Delete
                            @endif --}}
                            </td>
                        @endcan
                    </tr>
                @empty
                    <td class="text-base py-4">
                        <h2>No data available...</h2>
                    </td>
                @endforelse
            </tbody>
        </table>

        <style>
            /* .relative {
                height: 40px;
                margin: 2px;
                border-radius: 30px;
                border: none;
                box-shadow: none;
            } */

            .relative {
                height: 40px;
                margin: 2px;
                border-radius: 30px;
                border: none;
                box-shadow: none;
                color: blue;
            }

            .relative span {
                height: 40px;
                margin: 2px;
                color: gray;
                border-radius: 30px;
                border: none;
            }
        </style>

        <div class="py-10">
            {{ $posts->links() }}
        </div>

    </div>


</x-app-layout>
