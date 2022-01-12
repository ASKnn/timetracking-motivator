<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adding Redmine Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{!! route("add_new_redmine_user") !!}">
                        @csrf
                        <label>
                            <input type="text" name="redmine_id" value="{{ old('redmine_id') }}">

                        </label>
                        <button class="focus:outline-none text-sm w-24 py-3 rounded-md font-semibold text-white bg-blue-500 ring-2
hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50">Добавить</button>
                        @if (session('user_status_exist'))
                            <div class="alert alert-success">
                                {{ session('user_status_exist') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
