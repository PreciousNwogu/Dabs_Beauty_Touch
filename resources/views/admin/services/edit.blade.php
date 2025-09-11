@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Service</h1>
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $service->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $service->slug }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Base Price</label>
                <input type="number" step="0.01" name="base_price" class="form-control" value="{{ $service->base_price }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $service->description }}</textarea>
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
