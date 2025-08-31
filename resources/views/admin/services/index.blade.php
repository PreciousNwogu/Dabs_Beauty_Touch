@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Services</h1>
        <table class="table">
            <thead><tr><th>Name</th><th>Slug</th><th>Base Price</th><th></th></tr></thead>
            <tbody>
            @foreach($services as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->slug }}</td>
                    <td>{{ $s->base_price }}</td>
                    <td><a href="{{ route('admin.services.edit', $s) }}" class="btn btn-sm btn-primary">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
