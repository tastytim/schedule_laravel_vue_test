@extends('layouts.app')

@section('content')
<div class="container">
    <div id='app'>

        <div class="row justify-content-center">
            {{-- Componente Vue Router--}}

            <router-view></router-view>
        </div>
    </div>

</div>
@endsection
