@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-gray-900 text-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">{{ isset($betGuideline) ? 'Edit Guideline' : 'Add New Guideline' }}</h1>

    <form action="{{ isset($betGuideline) ? route('bet-guidelines.update', $betGuideline->id) : route('bet-guidelines.store') }}" method="POST">
        @csrf
        @if(isset($betGuideline))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block mb-1">Type</label>
            <select name="type" class="w-full rounded p-2 bg-gray-800 text-white">
                <option value="routine" {{ (old('type', $betGuideline->type ?? '') == 'routine') ? 'selected' : '' }}>Routine</option>
                <option value="rule" {{ (old('type', $betGuideline->type ?? '') == 'rule') ? 'selected' : '' }}>Rule</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $betGuideline->title ?? '') }}" class="w-full rounded p-2 bg-gray-800 text-white">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full rounded p-2 bg-gray-800 text-white">{{ old('description', $betGuideline->description ?? '') }}</textarea>
        </div>

        <div class="mb-4 flex items-center space-x-2">
            <input type="checkbox" name="is_active" {{ old('is_active', $betGuideline->is_active ?? false) ? 'checked' : '' }}>
            <label>Active</label>
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
