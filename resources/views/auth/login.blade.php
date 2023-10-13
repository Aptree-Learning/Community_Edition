<x-auth-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="text-center">
            <h1 class="text-primary text-3xl font-bold">Welcome Back!</h1>
            <p class="mt-2 text-gray-600">Let's build something great</p>
        </div>

        <x-validation-errors class="mb-4 mt-2" />

        @if (session('status'))
            <div class="mb-4 mt-2 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-8">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="mt-1 block w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="mt-4 block">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>


            <div class="mt-4">
                <button type="submit" class="btn-primary w-full font-bold">Sign in</button>
            </div>

            <div class="relative mt-3 flex items-center justify-center py-3">
                <div class="w-full border-b border-gray-300"></div>
                <p class="flex-shrink-0 bg-white px-6 text-sm text-gray-600">Or do it via other accounts</p>
                <div class="w-full border-b border-gray-300"></div>
            </div>

            <div class="flex justify-center gap-4">

                {{-- <a
                    href="{{ url('login/google') }}"
                    class="inline-flex items-center gap-2 rounded border-2 border-[#0077b5] px-5 py-3 text-sm font-medium text-[#0077b5] transition-colors hover:bg-transparent hover:text-[#0077b5] focus:outline-none focus:ring active:opacity-75"
                    target="_blank"
                    rel="noreferrer"
                    >
                    Login with Google

                    <svg class="h-5 w-5" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="white"/>
                        <g clip-path="url(#clip0_4953_12633)">
                        <path d="M29.7874 20.225C29.7874 19.5666 29.7291 18.9416 29.6291 18.3333H20.2124V22.0916H25.6041C25.3624 23.325 24.6541 24.3666 23.6041 25.075V27.575H26.8207C28.7041 25.8333 29.7874 23.2666 29.7874 20.225Z" fill="#4285F4"/>
                        <path d="M20.2124 30C22.9124 30 25.1707 29.1 26.8207 27.575L23.604 25.075C22.704 25.675 21.5624 26.0417 20.2124 26.0417C17.604 26.0417 15.3957 24.2833 14.604 21.9083H11.2874V24.4833C12.929 27.75 16.304 30 20.2124 30Z" fill="#34A853"/>
                        <path d="M14.6041 21.9083C14.3957 21.3083 14.2874 20.6667 14.2874 20C14.2874 19.3333 14.4041 18.6917 14.6041 18.0917V15.5167H11.2874C10.6041 16.8667 10.2124 18.3833 10.2124 20C10.2124 21.6167 10.6041 23.1333 11.2874 24.4833L14.6041 21.9083Z" fill="#FBBC05"/>
                        <path d="M20.2124 13.9583C21.6874 13.9583 23.004 14.4667 24.0457 15.4583L26.8957 12.6083C25.1707 10.9917 22.9124 10 20.2124 10C16.304 10 12.929 12.25 11.2874 15.5167L14.604 18.0917C15.3957 15.7167 17.604 13.9583 20.2124 13.9583Z" fill="#EA4335"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_4953_12633">
                        <rect width="20" height="20" fill="white" transform="translate(10 10)"/>
                        </clipPath>
                        </defs>
                    </svg>

                </a> --}}
                <a href="{{ url('login/google') }}"
                    target="_blank" rel="noreferrer">
                    <span class="sr-only">Google</span>
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="white" />
                        <g clip-path="url(#clip0_4953_12633)">
                            <path
                                d="M29.7874 20.225C29.7874 19.5666 29.7291 18.9416 29.6291 18.3333H20.2124V22.0916H25.6041C25.3624 23.325 24.6541 24.3666 23.6041 25.075V27.575H26.8207C28.7041 25.8333 29.7874 23.2666 29.7874 20.225Z"
                                fill="#4285F4" />
                            <path
                                d="M20.2124 30C22.9124 30 25.1707 29.1 26.8207 27.575L23.604 25.075C22.704 25.675 21.5624 26.0417 20.2124 26.0417C17.604 26.0417 15.3957 24.2833 14.604 21.9083H11.2874V24.4833C12.929 27.75 16.304 30 20.2124 30Z"
                                fill="#34A853" />
                            <path
                                d="M14.6041 21.9083C14.3957 21.3083 14.2874 20.6667 14.2874 20C14.2874 19.3333 14.4041 18.6917 14.6041 18.0917V15.5167H11.2874C10.6041 16.8667 10.2124 18.3833 10.2124 20C10.2124 21.6167 10.6041 23.1333 11.2874 24.4833L14.6041 21.9083Z"
                                fill="#FBBC05" />
                            <path
                                d="M20.2124 13.9583C21.6874 13.9583 23.004 14.4667 24.0457 15.4583L26.8957 12.6083C25.1707 10.9917 22.9124 10 20.2124 10C16.304 10 12.929 12.25 11.2874 15.5167L14.604 18.0917C15.3957 15.7167 17.604 13.9583 20.2124 13.9583Z"
                                fill="#EA4335" />
                        </g>
                        <defs>
                            <clipPath id="clip0_4953_12633">
                                <rect width="20" height="20" fill="white" transform="translate(10 10)" />
                            </clipPath>
                        </defs>
                    </svg>
                </a>

                {{-- <a href="{{ url('login/google') }}">
                    <span class="sr-only">Google</span>
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="white"/>
                        <g clip-path="url(#clip0_4953_12633)">
                        <path d="M29.7874 20.225C29.7874 19.5666 29.7291 18.9416 29.6291 18.3333H20.2124V22.0916H25.6041C25.3624 23.325 24.6541 24.3666 23.6041 25.075V27.575H26.8207C28.7041 25.8333 29.7874 23.2666 29.7874 20.225Z" fill="#4285F4"/>
                        <path d="M20.2124 30C22.9124 30 25.1707 29.1 26.8207 27.575L23.604 25.075C22.704 25.675 21.5624 26.0417 20.2124 26.0417C17.604 26.0417 15.3957 24.2833 14.604 21.9083H11.2874V24.4833C12.929 27.75 16.304 30 20.2124 30Z" fill="#34A853"/>
                        <path d="M14.6041 21.9083C14.3957 21.3083 14.2874 20.6667 14.2874 20C14.2874 19.3333 14.4041 18.6917 14.6041 18.0917V15.5167H11.2874C10.6041 16.8667 10.2124 18.3833 10.2124 20C10.2124 21.6167 10.6041 23.1333 11.2874 24.4833L14.6041 21.9083Z" fill="#FBBC05"/>
                        <path d="M20.2124 13.9583C21.6874 13.9583 23.004 14.4667 24.0457 15.4583L26.8957 12.6083C25.1707 10.9917 22.9124 10 20.2124 10C16.304 10 12.929 12.25 11.2874 15.5167L14.604 18.0917C15.3957 15.7167 17.604 13.9583 20.2124 13.9583Z" fill="#EA4335"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_4953_12633">
                        <rect width="20" height="20" fill="white" transform="translate(10 10)"/>
                        </clipPath>
                        </defs>
                    </svg>
                </a>
                <a href="{{ url('login/twitter') }}">
                    <span class="sr-only">Twitter</span>
                    <img src="{{ asset('img/twitter.svg') }}" class="w-6 h-6 mt-2" alt="">

                </a>
                <a href="{{ url('login/facebook') }}">
                    <span class="sr-only">Facebook</span>
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="8" fill="white"/>
                        <path d="M18.02 31.88C12.32 30.86 8 25.94 8 20C8 13.4 13.4 8 20 8C26.6 8 32 13.4 32 20C32 25.94 27.68 30.86 21.98 31.88L21.32 31.34H18.68L18.02 31.88Z" fill="url(#paint0_linear_4953_12643)"/>
                        <path d="M24.6798 23.36L25.2198 20H22.0398V17.66C22.0398 16.7 22.3998 15.98 23.8398 15.98H25.3998V12.92C24.5598 12.8 23.5998 12.68 22.7598 12.68C19.9998 12.68 18.0798 14.36 18.0798 17.36V20H15.0798V23.36H18.0798V31.82C18.7398 31.94 19.3998 32 20.0598 32C20.7198 32 21.3798 31.94 22.0398 31.82V23.36H24.6798Z" fill="white"/>
                        <defs>
                        <linearGradient id="paint0_linear_4953_12643" x1="20.0006" y1="31.1654" x2="20.0006" y2="7.99558" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#0062E0"/>
                        <stop offset="1" stop-color="#19AFFF"/>
                        </linearGradient>
                        </defs>
                    </svg>
                </a> --}}

            </div>

            <div class="mt-8 flex justify-center divide-x">

                <p class="pr-8 text-sm">New User? <a href="{{ url('register') }}" class="text-primary font-bold">Sign
                        Up!</a></p>
                <p class="pl-8 text-sm"><a href="{{ route('password.request') }}" class="text-primary font-bold">Reset
                        Password</a></p>
            </div>

        </form>
    </x-authentication-card>
</x-auth-layout>
