@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    {{-- Componente Vue --}}
        <appointment-component>
        </appointment-component>
    </div>
</div>
@endsection
