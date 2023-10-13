<div>

    <header class="flex justify-between bg-white px-16 py-6">
        <div>
            <h1 class="text-primary text-3xl font-bold leading-7 sm:leading-9">Settings</h1>
        </div>
        <div>
            <a href="" class="btn-primary">
                Force Reload
            </a>
        </div>
    </header>

    <div class="bg-gray-100 px-16 py-12">

        <div class="grid grid-cols-3 gap-8">
            <div>
                <ul role="list" class="divide-y divide-gray-200 bg-white shadow-md">
                    <li class="">
                        <a href="#app"
                            class="flex space-x-3 border-l-4 border-darkgreen px-6 py-4 hover:bg-darkgreen/20">
                            <x-heroicon-s-cog class="h-6 w-6 text-gray-600 group-hover:text-white" />
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">App Settings</h3>
                                    <p class="text-sm text-gray-500 group-hover:text-white">1 config</p>
                                </div>
                                <p class="text-sm text-gray-500 group-hover:text-white">App general settings</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#social" class="flex space-x-3 px-6 py-4 hover:bg-darkgreen/20">
                            <x-heroicon-s-cursor-click class="h-6 w-6 text-gray-600 group-hover:text-white" />
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">Social Media Login</h3>
                                    <p class="text-sm text-gray-500 group-hover:text-white">3 configs</p>
                                </div>
                                <p class="text-sm text-gray-500 group-hover:text-white">Security Credentials for
                                    Facebook, Twitter and Google.</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#categories" class="flex space-x-3 px-6 py-4 hover:bg-darkgreen/20">
                            <x-heroicon-s-cursor-click class="h-6 w-6 text-gray-600 group-hover:text-white" />
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">Categories</h3>
                                    <p class="text-sm text-gray-500 group-hover:text-white"></p>
                                </div>
                                <p class="text-sm text-gray-500 group-hover:text-white">Manage Categories</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#integrations" class="flex space-x-3 px-6 py-4 hover:bg-darkgreen/20">
                            <x-heroicon-s-cursor-click class="h-6 w-6 text-gray-600 group-hover:text-white" />
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">Integrations</h3>
                                    <p class="text-sm text-gray-500 group-hover:text-white"></p>
                                </div>
                                <p class="text-sm text-gray-500 group-hover:text-white">Copy integration settings</p>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="col-span-2 space-y-8">

                <section class="col-span-3">
                    @foreach ($settings as $config)
                        <div class="border-b py-6">
                            @livewire('settings.setting-item', ['id' => $config->id], key('setting-' . $config->id . '-' . time()))
                        </div>
                    @endforeach
                </section>

                <section id="app">
                    <h3 class="text-primary text-xl font-bold">App Settings</h3>

                    <div>
                        <div class="mt-8 rounded-md border bg-white p-6">

                            <form wire:submit.prevent="saveAppForm">
                                {{ $this->appForm }}

                                <button type="submit" class="btn-primary btn-sm mt-4">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </section>

                <section id="openai">
                    <h3 class="text-primary text-xl font-bold">OpenAI</h3>

                    <div class="space-y-8">

                        <div class="col-span-2 mt-8 rounded-md border bg-white p-6">
                            <h4 class="text-primary mb-8 font-bold">OpenAI</h4>
                            <form wire:submit.prevent="saveOpenAIform">
                                {{ $this->openaiform }}
                                <button type="submit" class="btn-primary btn-sm mt-4">Save Changes</button>
                            </form>
                        </div>

                    </div>
                </section>

                <section id="smtp">
                    <h3 class="text-primary text-xl font-bold">SMTP</h3>

                    <div class="space-y-8">

                        <div class="col-span-2 mt-8 rounded-md border bg-white p-6">
                            <h4 class="text-primary mb-8 font-bold">SMTP</h4>
                            <form wire:submit.prevent="saveSmtpForm">
                                {{ $this->smtpform }}
                                <button type="submit" class="btn-primary btn-sm mt-4">Save Changes</button>
                            </form>
                        </div>

                    </div>
                </section>

                <section id="social">
                    <h3 class="text-primary text-xl font-bold">Social Media Login</h3>

                    <div class="space-y-8">
                        <div class="col-span-2 mt-8 rounded-md border bg-white p-6">
                            <h4 class="text-primary mb-8 font-bold">Google</h4>
                            <form wire:submit.prevent="saveGoogleForm">
                                {{ $this->googleForm }}
                                <button type="submit" class="btn-primary btn-sm mt-4">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </section>

                <div class="col-span-3 mb-8 border-t border-dashed"></div>

                <section class="col-span-3" id="categories">
                    <h3 class="text-primary mb-8 text-xl font-bold">Manage Categories</h3>
                    <p class="text-primary">Select the Course Libraries you want to be visible in your accounts template
                        library</p>

                    {{ $this->table }}
                </section>

                <div class="col-span-3 mb-8 border-t border-dashed"></div>

                <section class="col-span-3" id="categories">
                    <h3 class="text-primary mb-8 text-xl font-bold">Integrations</h3>
                    <p class="text-primary">You can copy values and use Zapier</p>

                </section>
                <div class="rounded border border-gray-300 bg-white p-6 shadow mt-2" id="integrations">
                    <div class="settings-page grid grid-cols-6 gap-6">
                        <div class="col-span-2">
                            <h3 class="text-primary font-bold">Zapier API Key</h3>
                            <div class="text-primary text-sm">Zapier auth API Key</div>
                        </div>
                        <div class="col-span-3">
                            <div class="flex">
                                <div class="rounded border border-gray-200 px-4 py-[15px] flex-1 overflow-hidden text-ellipsis mr-2">
                                    {{ $api_key }}                                
                                </div>
                                <div x-data="{
                                    copyText: '{{ $api_key }}',
                                    copyNotification: false,
                                    copyToClipboard() {
                                        navigator.clipboard.writeText(this.copyText);
                                        this.copyNotification = true;
                                        let that = this;
                                        setTimeout(function() {
                                            that.copyNotification = false;
                                        }, 3000);
                                    }
                                }" class="relative z-20 flex items-center">
                                    <button @click="copyToClipboard();"
                                        class="border-neutral-200/60 hover:bg-neutral-100 text-neutral-500 hover:text-neutral-600 group flex h-auto w-16 cursor-pointer flex-col items-center justify-center rounded-md border bg-white px-3 pb-1.5 pt-2 text-[0.65rem] font-medium uppercase focus:bg-white focus:outline-none active:bg-white">
                                        <svg x-show="!copyNotification"
                                            class="mb-1 h-5 w-5 flex-shrink-0 stroke-current"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>
                                        <span x-show="!copyNotification">Copy</span>
                                        <svg x-show="copyNotification"
                                            class="mb-1 h-5 w-5 flex-shrink-0 stroke-current text-green-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" x-cloak>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                        </svg>
                                        <span x-show="copyNotification" class="tracking-tight text-green-500"
                                            x-cloak>Copied</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="settings-page grid grid-cols-6 gap-6 mt-4">
                        <div class="col-span-2">
                            <h3 class="text-primary font-bold">Zapier Website Host</h3>
                            <div class="text-primary text-sm">Zapier website host name</div>
                        </div>
                        <div class="col-span-3">
                            <div class="flex">
                                <div class="rounded border border-gray-200 px-4 py-[15px] flex-1 overflow-hidden text-ellipsis mr-2">
                                    {{ $host }}                                
                                </div>
                                <div x-data="{
                                    copyText: '{{ $host }}',
                                    copyNotification: false,
                                    copyToClipboard() {
                                        navigator.clipboard.writeText(this.copyText);
                                        this.copyNotification = true;
                                        let that = this;
                                        setTimeout(function() {
                                            that.copyNotification = false;
                                        }, 3000);
                                    }
                                }" class="relative z-20 flex items-center">
                                    <button @click="copyToClipboard();"
                                        class="border-neutral-200/60 hover:bg-neutral-100 text-neutral-500 hover:text-neutral-600 group flex h-auto w-16 cursor-pointer flex-col items-center justify-center rounded-md border bg-white px-3 pb-1.5 pt-2 text-[0.65rem] font-medium uppercase focus:bg-white focus:outline-none active:bg-white">
                                        <svg x-show="!copyNotification"
                                            class="mb-1 h-5 w-5 flex-shrink-0 stroke-current"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>
                                        <span x-show="!copyNotification">Copy</span>
                                        <svg x-show="copyNotification"
                                            class="mb-1 h-5 w-5 flex-shrink-0 stroke-current text-green-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" x-cloak>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                        </svg>
                                        <span x-show="copyNotification" class="tracking-tight text-green-500"
                                            x-cloak>Copied</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
