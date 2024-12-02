@php($record = $this->record)
<x-filament::page>

    <a href="{{ route('filament.pages.kanban/{project}', ['project' => $record->project->id]) }}"
       class="flex items-center gap-1 text-gray-500 hover:text-gray-700 font-medium text-xs">
        <x-heroicon-o-arrow-left class="w-4 h-4"/> {{ __('Back to kanban board') }}
    </a>

    <div class="w-full flex md:flex-row flex-col gap-5">

        <x-filament::card class="md:w-2/3 w-full flex flex-col gap-5">
            <div class="w-full flex flex-col gap-0">
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1 text-sm text-gray-500">
                        {{ $record->project->name }}
                    </span>
                </div>
                <span class="text-xl text-gray-700">
                    {{ $record->name }}
                </span>
            </div>
            <div class="w-full flex items-center gap-2">
                <div class="px-2 py-1 rounded flex items-center justify-center text-center text-xs text-white"
                     style="background-color: {{ $record->status->color }};">
                    {{ $record->status->name }}
                </div>
                <div class="px-2 py-1 rounded flex items-center justify-center text-center text-xs text-white"
                     style="background-color: {{ $record->priority->color }};">
                    {{ $record->priority->name }}
                </div>
                <div class="px-2 py-1 rounded flex items-center justify-center text-center text-xs text-white"
                     style="background-color: {{ $record->type->color }};">
                    <x-icon class="h-3 text-white" name="{{ $record->type->icon }}"/>
                    <span class="ml-2">
                        {{ $record->type->name }}
                    </span>
                </div>
            </div>
            <div class="w-full flex flex-col gap-0 pt-5">
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Description') }}
                </span>
                <div class="w-full prose">
                    {!! $record->content !!}
                </div>
            </div>
        </x-filament::card>

        <x-filament::card class="md:w-1/3 w-full flex flex-col">
            <div class="w-full flex flex-col gap-1" wire:ignore>
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Owner') }}
                </span>
                <div class="w-full flex items-center gap-1 text-gray-500">
                    <x-user-avatar :user="$record->owner"/>
                    {{ $record->owner->name }}
                </div>
            </div>

            <div class="w-full flex flex-col gap-1 pt-3" wire:ignore>
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Responsible') }}
                </span>
                <div class="w-full flex items-center gap-1 text-gray-500">
                    @if($record->responsible)
                        <x-user-avatar :user="$record->responsible"/>
                    @endif
                    {{ $record->responsible?->name ?? '-' }}
                </div>
            </div>

            <div class="w-full flex flex-col gap-1 pt-3">
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Deadline') }}
                </span>
                <div class="w-full text-gray-500">
                    {{ \Carbon\Carbon::parse($record->deadline)->format(__('Y-m-d g:i A')) }}
                    <span class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($record->deadline)->diffForHumans() }}
                    </span>
                </div>
            </div>

            <div class="w-full flex flex-col gap-1 pt-3">
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Creation date') }}
                </span>
                <div class="w-full text-gray-500">
                    {{ $record->created_at->format(__('Y-m-d g:i A')) }}
                    <span class="text-xs text-gray-400">
                        ({{ $record->created_at->diffForHumans() }})
                    </span>
                </div>
            </div>

            <div class="w-full flex flex-col gap-1 pt-3">
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Last update') }}
                </span>
                <div class="w-full text-gray-500">
                    {{ $record->updated_at->format(__('Y-m-d g:i A')) }}
                    <span class="text-xs text-gray-400">
                        ({{ $record->updated_at->diffForHumans() }})
                    </span>
                </div>
            </div>

            <div class="w-full flex flex-col gap-1 pt-3">
                <span class="text-gray-500 text-sm font-medium">
                    {{ __('Reminder') }}
                </span>
                <div class="w-full text-gray-500">
                    @if($record->reminder_at)
                        {{ \Carbon\Carbon::parse($record->reminder_at)->format(__('Y-m-d g:i A')) }}
                        <span class="text-xs text-gray-400">
                            ({{ \Carbon\Carbon::parse($record->reminder_at)->diffForHumans() }})
                        </span>
                    @else
                        <span class="text-gray-400">{{ __('No reminder set') }}</span>
                    @endif
                </div>
            </div>
        </x-filament::card>

    </div>

    <div class="w-full flex md:flex-row flex-col gap-5">

        <x-filament::card class="md:w-2/3 w-full flex flex-col">
            <div class="w-full flex items-center gap-2">
                <button wire:click="selectTab('comments')"
                        class="md:text-xl text-sm p-3 border-b-2 border-transparent hover:border-primary-500 flex items-center
                        gap-1 @if($tab === 'comments') border-primary-500 text-primary-500 @else text-gray-700 @endif">
                    {{ __('Comments') }}
                </button>
                <button wire:click="selectTab('activities')"
                        class="md:text-xl text-sm p-3 border-b-2 border-transparent hover:border-primary-500
                        @if($tab === 'activities') border-primary-500 text-primary-500 @else text-gray-700 @endif">
                    {{ __('Activities') }}
                </button>
            </div>
            @if($tab === 'comments')
                <form wire:submit.prevent="submitComment" class="pb-5">
                    {{ $this->form }}
                    <button type="submit"
                            class="px-3 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded mt-3">
                        {{ __($selectedCommentId ? 'Edit comment' : 'Add comment') }}
                    </button>
                    @if($selectedCommentId)
                        <button type="button" wire:click="cancelEditComment"
                                class="px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded mt-3">
                            {{ __('Cancel') }}
                        </button>
                    @endif
                </form>
                @foreach($record->comments->sortByDesc('created_at') as $comment)
                    <div
                        class="w-full flex flex-col gap-2 @if(!$loop->last) pb-5 mb-5 border-b border-gray-200 @endif ticket-comment">
                        <div class="w-full flex justify-between">
                            <span class="flex items-center gap-1 text-gray-500 text-sm">
                                <span class="font-medium flex items-center gap-1">
                                    <x-user-avatar :user="$comment->user"/>
                                    {{ $comment->user->name }}
                                </span>
                                <span class="text-gray-400 px-2">|</span>
                                {{ $comment->created_at->format('Y-m-d g:i A') }}
                                ({{ $comment->created_at->diffForHumans() }})
                            </span>
                            @if($this->isAdministrator() || $comment->user_id === auth()->user()->id)
                                <div class="actions flex items-center gap-2">
                                    <button type="button" wire:click="editComment({{ $comment->id }})"
                                            class="text-primary-500 text-xs hover:text-primary-600 hover:underline">
                                        {{ __('Edit') }}
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button type="button" wire:click="deleteComment({{ $comment->id }})"
                                            class="text-danger-500 text-xs hover:text-danger-600 hover:underline">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="w-full prose">
                            {!! $comment->content !!}
                        </div>
                    </div>
                @endforeach
            @endif
            @if($tab === 'activities')
                <div class="w-full flex flex-col pt-5">
                    @if($record->activities->count())
                        @foreach($record->activities->sortByDesc('created_at') as $activity)
                            <div class="w-full flex flex-col gap-2
                                 @if(!$loop->last) pb-5 mb-5 border-b border-gray-200 @endif">
                                <span class="flex items-center gap-1 text-gray-500 text-sm">
                                    <span class="font-medium flex items-center gap-1">
                                        <x-user-avatar :user="$activity->user"/>
                                        {{ $activity->user->name }}
                                    </span>
                                    <span class="text-gray-400 px-2">|</span>
                                    {{ $activity->created_at->format('Y-m-d g:i A') }}
                                    ({{ $activity->created_at->diffForHumans() }})
                                </span>
                                <div class="w-full flex items-center gap-10">
                                    <span class="text-gray-400">{{ $activity->oldStatus->name }}</span>
                                    <x-heroicon-o-arrow-right class="w-6 h-6"/>
                                    <span style="color: {{ $activity->newStatus->color }}">
                                        {{ $activity->newStatus->name }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <span class="text-gray-400 text-sm font-medium">
                            {{ __('No activities yet!') }}
                        </span>
                    @endif
                </div>
            @endif
        </x-filament::card>

        <div class="md:w-1/3 w-full flex flex-col"></div>

    </div>

</x-filament::page>

@push('scripts')
    <script>
        window.addEventListener('shareTicket', (e) => {
            const text = e.detail.url;
            const textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('Unable to copy to clipboard', err);
            }
            document.body.removeChild(textArea);
            new Notification()
                .success()
                .title('{{ __('Url copied to clipboard') }}')
                .duration(6000)
                .send()
        });
    </script>
@endpush
