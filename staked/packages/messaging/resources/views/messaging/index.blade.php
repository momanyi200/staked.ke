@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">My Conversations</h3>

    <ul class="list-group">
        @forelse($conversations as $conversation)
            <li class="list-group-item d-flex justify-content-between">
                <span>
                    With: {{ $conversation->users->where('id', '!=', auth()->id())->pluck('name')->join(', ') }}
                </span>
                <a href="{{ route('messaging.show', $conversation) }}" class="btn btn-sm btn-primary">Open</a>
            </li>
        @empty
            <li class="list-group-item">No conversations yet.</li>
        @endforelse
    </ul>
</div>
@endsection
