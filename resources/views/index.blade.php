@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div id="game-app">
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{mix('js/game/main.js')}}" defer></script>
@endpush
@push('scripts_body')
    <script>
        window.theLuck.set('sessionId', @json($sessionId));
    </script>
@endpush