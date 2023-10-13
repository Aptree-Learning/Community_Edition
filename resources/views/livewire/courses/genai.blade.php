<form action="" wire:submit.prevent="submit">
    <h2 class="mb-2">Please explain what you want chat-gpt to write for your course end</h2>
    <textarea wire:model.defer="search" type="text" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 prose max-w-none break-words border-gray-300"></textarea>
    <button class="mt-3 btn-primary btn-sm" type="submit"><x-loading/> Generate</button>
</form>
