<x-app-layout>
    <header class="flex justify-between px-8 py-6 pl-16 bg-white">
        <h1 class="text-4xl font-bold leading-7 text-primary sm:leading-9">{{ Str::ucfirst($team->name) }}</h1>
        <div>
            
        </div>
    </header>
    <div>
        <div class="px-8 py-12 pl-16 space-y-8 bg-gray-100">

            @livewire('teams.graph', ['team_id' => $team->id])
            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif

            @if (Auth::user()->isAdmin())
                @livewire('teams.owner-form', ['team' => $team])
            @endif
        </div>
    </div>

</x-app-layout>
