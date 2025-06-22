<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile Settings') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Last updated: {{ now()->format('M d, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Navigation -->
            <div class="hidden md:block mb-8">
                <nav class="flex space-x-4" aria-label="Profile navigation">
                    <a href="#profile-info" class="px-3 py-2 font-medium text-sm rounded-md text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900">
                        Profile Information
                    </a>
                    <a href="#password" class="px-3 py-2 font-medium text-sm rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        Update Password
                    </a>
                    <a href="#delete-account" class="px-3 py-2 font-medium text-sm rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        Delete Account
                    </a>
                </nav>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden mb-6">
                <label for="profile-tabs" class="sr-only">Select a tab</label>
                <select id="profile-tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-700">
                    <option value="#profile-info">Profile Information</option>
                    <option value="#password">Update Password</option>
                    <option value="#delete-account">Delete Account</option>
                </select>
            </div>

            <!-- Profile Information Section -->
            <div id="profile-info" class="mb-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Information
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Update your account's profile information and email address.
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="max-w-xl mx-auto">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password Section -->
            <div id="password" class="mb-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Update Password
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Ensure your account is using a long, random password to stay secure.
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="max-w-xl mx-auto">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div id="delete-account">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Account
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Permanently delete your account.
                        </p>
                    </div>
                    <div class="p-6 bg-red-50 dark:bg-red-900 bg-opacity-10">
                        <div class="max-w-xl mx-auto">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple tab switching for mobile
        document.getElementById('profile-tabs').addEventListener('change', function() {
            const selectedTab = this.value;
            document.querySelector(selectedTab).scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</x-app-layout>