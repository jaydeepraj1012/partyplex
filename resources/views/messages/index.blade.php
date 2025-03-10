@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Messages</h1>
        
        @if(session('success'))
            <div class="mb-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if(count($conversations) > 0)
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($conversations as $user)
                            <a href="{{ route('messages.show', $user->id) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="py-4 flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        @if($user->profile_image)
                                            <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                                <span class="text-indigo-800 dark:text-indigo-200 font-medium text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $user->lastMessage->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="mt-1">
                                            <p class="text-sm text-gray-600 dark:text-gray-300 truncate">
                                                @if($user->lastMessage->sender_id === auth()->id())
                                                    <span class="text-gray-400 dark:text-gray-500">You: </span>
                                                @endif
                                                {{ $user->lastMessage->message }}
                                            </p>
                                        </div>
                                        @if($user->unreadCount > 0)
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                    {{ $user->unreadCount }} new {{ Str::plural('message', $user->unreadCount) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No messages</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You don't have any conversations yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 