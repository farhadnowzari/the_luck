@extends('layouts.main')
@section('content')
    <div class="h-100 d-flex align-items-center" id="game-app">
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