@extends('layouts.app')

@section('title', 'Conversation with ' . $receiver->name)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('messages.index') }}" class="inline-flex items-center mr-4 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Messages
                </a>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    <span class="mr-2">Conversation with</span>
                    <span class="text-indigo-600 dark:text-indigo-400">{{ $receiver->name }}</span>
                </h1>
            </div>
            
            <div class="flex items-center" id="user-status-container">
                <span id="status-indicator" class="inline-block w-3 h-3 rounded-full mr-2 {{ $receiver->is_online ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                <span id="status-text" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $receiver->is_online ? 'Online' : ($receiver->last_seen ? 'Last seen ' . $receiver->last_seen->diffForHumans() : 'Offline') }}
                </span>
            </div>
            
            @if(isset($booking))
                <div class="bg-indigo-50 dark:bg-indigo-900 px-4 py-2 rounded-md">
                    <p class="text-sm text-indigo-800 dark:text-indigo-200">
                        <i class="fas fa-bookmark mr-1"></i> Regarding Booking #{{ $booking->id }}
                    </p>
                </div>
            @endif
        </div>
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Messages Container -->
            <div class="p-6 h-[500px] flex flex-col">
                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto mb-4 p-2" id="messagesContainer">
                    @if(count($messages) > 0)
                        <div class="space-y-4" id="messagesList">
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} message-item" data-message-id="{{ $message->id }}">
                                    <div class="max-w-[70%]">
                                        @if($message->sender_id !== auth()->id())
                                            <div class="flex items-center mb-1">
                                                <div class="mr-2">
                                                    @if($message->sender->profile_image)
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $message->sender->profile_image) }}" alt="{{ $message->sender->name }}">
                                                    @else
                                                        <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                                            <span class="text-indigo-800 dark:text-indigo-200 font-medium text-sm">{{ substr($message->sender->name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $message->sender->name }}</span>
                                            </div>
                                        @endif
                                        
                                        <div class="{{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }} p-3 rounded-lg">
                                            <p class="text-sm break-words">{{ $message->message }}</p>
                                            
                                            @if($message->attachment)
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" class="text-xs {{ $message->sender_id === auth()->id() ? 'text-indigo-200 hover:text-white' : 'text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300' }} underline">
                                                        <i class="fas fa-paperclip mr-1"></i> View Attachment
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="mt-1 text-xs {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }} text-gray-500 dark:text-gray-400">
                                            {{ $message->created_at->format('M d, g:i A') }}
                                            @if($message->sender_id === auth()->id())
                                                @if($message->is_read)
                                                    <span class="ml-1 text-green-600 dark:text-green-400 message-status"><i class="fas fa-check-double"></i> Read</span>
                                                @else
                                                    <span class="ml-1 message-status"><i class="fas fa-check"></i> Sent</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="h-full flex items-center justify-center" id="empty-messages">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No messages yet</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start the conversation with {{ $receiver->name }}.</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Typing Indicator -->
                <div id="typing-indicator" class="ml-4 mb-2 hidden">
                    <div class="flex items-center">
                        <div class="mr-2">
                            @if($receiver->profile_image)
                                <img class="h-6 w-6 rounded-full object-cover" src="{{ asset('storage/' . $receiver->profile_image) }}" alt="{{ $receiver->name }}">
                            @else
                                <div class="h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                    <span class="text-indigo-800 dark:text-indigo-200 font-medium text-xs">{{ substr($receiver->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="typing-animation">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Message Form -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <form id="messageForm" action="{{ route('messages.store') }}" method="POST" class="flex items-end space-x-2" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                        @if(isset($booking))
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        @endif
                        
                        <div class="flex-1">
                            <label for="message" class="sr-only">Message</label>
                            <textarea id="message" name="message" rows="2" 
                                      class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm resize-none"
                                      placeholder="Type your message..." required></textarea>
                        </div>
                        
                        <div class="flex space-x-2">
                            <div>
                                <label for="attachment" class="sr-only">Attachment</label>
                                <div class="relative">
                                    <input type="file" id="attachment" name="attachment" class="hidden" accept="image/*,.pdf,.doc,.docx">
                                    <button type="button" onclick="document.getElementById('attachment').click()" 
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" id="sendMessageBtn" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                <i class="fas fa-paper-plane mr-2"></i> Send
                            </button>
                        </div>
                    </form>
                    <div id="filePreview" class="mt-2 hidden">
                        <div class="flex items-center bg-gray-50 dark:bg-gray-700 p-2 rounded-md">
                            <div class="mr-2">
                                <i class="fas fa-file text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <span id="fileName" class="text-sm text-gray-800 dark:text-gray-200 truncate"></span>
                            <button type="button" id="removeFile" class="ml-auto text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    /* Typing animation */
    .typing-animation {
        display: flex;
        align-items: center;
    }
    
    .dot {
        height: 8px;
        width: 8px;
        margin-right: 3px;
        border-radius: 50%;
        background-color: #CBD5E1;
        animation: bounce 1.5s infinite ease-in-out;
    }
    
    .dot:nth-child(1) {
        animation-delay: 0s;
    }
    
    .dot:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .dot:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes bounce {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-5px);
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messagesContainer = document.getElementById('messagesContainer');
        const messagesList = document.getElementById('messagesList');
        const emptyMessages = document.getElementById('empty-messages');
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('message');
        const fileInput = document.getElementById('attachment');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const removeFileBtn = document.getElementById('removeFile');
        const typingIndicator = document.getElementById('typing-indicator');
        const statusIndicator = document.getElementById('status-indicator');
        const statusText = document.getElementById('status-text');
        
        // Message variables
        const userId = {{ auth()->id() }};
        const receiverId = {{ $receiver->id }};
        let typingTimeout;
        let isTyping = false;
        
        // Initialize Pusher
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });
        
        // Subscribe to private channel for the current user
        const chatChannel = pusher.subscribe('private-chat.' + userId);
        
        // Listen for new messages
        chatChannel.bind('message.sent', function(data) {
            console.log('Received message via Pusher:', data);
            
            // Only process messages from the current conversation
            if (data.sender_id === receiverId) {
                // Play notification sound
                const audio = new Audio('/sounds/message.mp3');
                audio.play().catch(e => console.log('Audio play failed:', e));
                
                // Hide typing indicator
                typingIndicator.classList.add('hidden');
                
                // Show toast notification
                toastr.info(data.sender.name + ': ' + data.message);
                
                // Add new message to the chat
                appendMessage(data, false);
                
                // Mark the message as read
                markMessageAsRead(data.sender_id);
            }
        });
        
        // Subscribe to user status channel
        const statusChannel = pusher.subscribe('user-status');
        
        // Listen for user status changes
        statusChannel.bind('user.status', function(data) {
            console.log('User status changed:', data);
            
            if (data.user_id === receiverId) {
                updateUserStatus(data.status, data.last_seen);
            }
        });
        
        // Scroll to bottom of messages initially
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        // Handle file selection
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    filePreview.classList.remove('hidden');
                } else {
                    filePreview.classList.add('hidden');
                }
            });
        }
        
        // Handle remove file
        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.classList.add('hidden');
            });
        }
        
        // Handle typing indicator
        if (messageInput) {
            messageInput.addEventListener('input', function() {
                if (!isTyping) {
                    isTyping = true;
                    // You would emit a typing event here
                }
                
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(function() {
                    isTyping = false;
                    // You would emit a stopped typing event here
                }, 2000);
            });
        }
        
        // Check user status periodically
        fetchUserStatus();
        setInterval(fetchUserStatus, 30000); // Check every 30 seconds
        
        // Handle form submission
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                
                if (!messageInput.value.trim() && (!fileInput.files || fileInput.files.length === 0)) {
                    toastr.error('Please enter a message or attach a file');
                    return false;
                }
                
                // Show loading animation in the send button
                const submitBtn = document.getElementById('sendMessageBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
                
                // Submit form via AJAX
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Clear form fields
                        messageInput.value = '';
                        fileInput.value = '';
                        filePreview.classList.add('hidden');
                        
                        // Show success toast
                        toastr.success('Message sent successfully');
                        
                        // Append new message to the chat for the sender immediately
                        // This gives instant feedback without waiting for the pusher event
                        appendMessage({
                            id: data.message.id,
                            message: data.message.message,
                            attachment: data.message.attachment,
                            attachment_url: data.message.attachment_url,
                            created_at: data.message.created_at,
                            sender_id: userId
                        }, true);
                    } else {
                        toastr.error(data.message || 'An error occurred while sending the message');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while sending the message');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Send';
                });
            });
        }
        
        // Function to append a new message to the chat
        function appendMessage(message, isSender) {
            // If this is the first message, remove the empty state
            if (emptyMessages && !messagesList) {
                // Create the messages list if it doesn't exist
                const newMessagesList = document.createElement('div');
                newMessagesList.classList.add('space-y-4');
                newMessagesList.id = 'messagesList';
                
                // Replace empty state with messages list
                messagesContainer.innerHTML = '';
                messagesContainer.appendChild(newMessagesList);
                
                // Update reference
                messagesList = newMessagesList;
            }
            
            // Create message HTML
            const messageHtml = `
                <div class="flex ${isSender ? 'justify-end' : 'justify-start'} message-item" data-message-id="${message.id}">
                    <div class="max-w-[70%]">
                        ${!isSender ? `
                            <div class="flex items-center mb-1">
                                <div class="mr-2">
                                    ${message.sender.profile_image ? `
                                        <img class="h-8 w-8 rounded-full object-cover" src="${message.sender.profile_image}" alt="${message.sender.name}">
                                    ` : `
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                            <span class="text-indigo-800 dark:text-indigo-200 font-medium text-sm">${message.sender.name.charAt(0)}</span>
                                        </div>
                                    `}
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">${message.sender.name}</span>
                            </div>
                        ` : ''}
                        
                        <div class="${isSender ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200'} p-3 rounded-lg">
                            <p class="text-sm break-words">${message.message}</p>
                            
                            ${message.attachment ? `
                                <div class="mt-2">
                                    <a href="${message.attachment_url}" target="_blank" class="text-xs ${isSender ? 'text-indigo-200 hover:text-white' : 'text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300'} underline">
                                        <i class="fas fa-paperclip mr-1"></i> View Attachment
                                    </a>
                                </div>
                            ` : ''}
                        </div>
                        
                        <div class="mt-1 text-xs ${isSender ? 'text-right' : 'text-left'} text-gray-500 dark:text-gray-400">
                            ${message.created_at}
                            ${isSender ? `
                                <span class="ml-1 message-status"><i class="fas fa-check"></i> Sent</span>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            
            // Add the new message to the DOM
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = messageHtml.trim();
            const newMessage = tempDiv.firstChild;
            messagesList.appendChild(newMessage);
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        // Function to mark messages as read
        function markMessageAsRead(senderId) {
            fetch('{{ route('messages.read') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    sender_id: senderId
                })
            });
        }
        
        // Function to fetch user status
        function fetchUserStatus() {
            fetch('{{ route('users.status', $receiver) }}')
                .then(response => response.json())
                .then(data => {
                    updateUserStatus(data.is_online ? 'online' : 'offline', data.last_seen);
                });
        }
        
        // Function to update user status display
        function updateUserStatus(status, lastSeen) {
            if (status === 'online') {
                statusIndicator.classList.remove('bg-gray-400');
                statusIndicator.classList.add('bg-green-500');
                statusText.textContent = 'Online';
            } else {
                statusIndicator.classList.remove('bg-green-500');
                statusIndicator.classList.add('bg-gray-400');
                statusText.textContent = lastSeen ? 'Last seen ' + lastSeen : 'Offline';
            }
        }
    });
</script>
@endsection
@endsection 