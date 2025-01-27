<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-body class="flex gap-4 items-start">
            <x-misc.box>
                <strong>E</strong>VENT - <strong>M</strong>ANAGEMENT - <strong>S</strong>YSTEM
                <p class="text-xs italic">by TNZ Dienstleistungen | Build @php echo config('build.nr') . " vom " . config('build.date') @endphp </p>
            </x-misc.box>
            <x-misc.box class="grow">
                <div class="flex justify-between items-start gap-4">
                    <x-misc.heading>Was gibts Neues?</x-misc.heading>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('news.create') }}">
                            <x-primary-button>Neuer Beitrag</x-primary-button>
                        </a>
                    @endif
                </div>
                <div class="flex flex-col  gap-2 py-4">
                    @forelse($news as $new)
                        <article class="bg-gray-100 p-4">
                            <div class="border-b pb-2 flex justify-between gap-4 items-start">
                                <p>
                                    <span class="font-semibold">{{ $new->title }}</span> 
                                    <span class="text-sm bg-gray-200 px-1.5 rounded">{{ $new->user->name }}, {{ $new->created_at->format("d.m.Y, H:i") }} Uhr</span>
                                </p>
                                @if($new->is_important)
                                    <span class="bg-red-500 px-1.5 font-semibold text-white rounded text-sm">Wichtig</span>
                                @endif
                            </div>
                            <div class="pt-2">{{ $new->content }}</div>
                        </article>
                    @empty
                        <p>Noch keine Beiträge vorhanden!</p>
                    @endforelse
                </div>

                {{ $news->links() }}

            </x-misc.box>
    
    </x-body>
</x-app-layout>
