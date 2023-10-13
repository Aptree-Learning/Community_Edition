<header x-data="{ isOpen: false }"  class="bg-white border-b shadow-sm">
    <nav class="flex items-center justify-between p-6 mx-auto max-w-7xl lg:px-8" aria-label="Global">
      <a href="#" class="-m-1.5 p-1.5">
        <span class="sr-only">{{ config('app.name') }}</span>
        <img class="w-auto h-8" src="{{ site_logo() }}" alt="">
      </a>
      <div class="flex lg:hidden">
        <button x-on:click="isOpen = !isOpen" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-primary">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
      <div class="items-center hidden lg:flex lg:gap-x-12">
        <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Product</a>
  
        <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Features</a>
  
        <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Marketplace</a>
  
        <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Company</a>
  
        <a href="{{ url('login') }}" class="px-3 py-2 text-sm font-semibold leading-6 text-gray-900 transition duration-300 bg-yellow-400 hover:bg-yellow-500">Log in <span aria-hidden="true">&rarr;</span></a>
      </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div 
      x-show="isOpen"
      class="lg:hidden" role="dialog" aria-modal="true">
      <!-- Background backdrop, show/hide based on slide-over state. -->
      <div class="fixed inset-0 z-10"></div>
      <div class="fixed inset-y-0 right-0 z-10 w-full px-6 py-6 overflow-y-auto bg-white sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
          <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img class="w-auto h-8" src="{{ site_logo() }}" alt="">
          </a>
          <button x-on:click="isOpen = false"  type="button" class="-m-2.5 rounded-md p-2.5 text-primary">
            <span class="sr-only">Close menu</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flow-root mt-6">
          <div class="-my-6 divide-y divide-gray-500/10">
            <div class="py-6 space-y-2">
              <a href="#" class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Product</a>
  
              <a href="#" class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Features</a>
  
              <a href="#" class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Marketplace</a>
  
              <a href="#" class="block px-3 py-2 -mx-3 text-base font-semibold leading-7 text-gray-900 rounded-lg hover:bg-gray-50">Company</a>
            </div>
            <div class="py-6">
              <a href="{{ url('login') }}" class="-mx-3 block rounded-lg py-2.5 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  