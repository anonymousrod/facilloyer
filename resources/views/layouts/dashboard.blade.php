@extends('layouts.master_dash')
@section('title', 'Dashboard')
@section('content')
    @if ($message)
        <div class="alert alert-warning text-center">
            <h5 class="text-warning">{{ $message }}</h5>
        </div>
    @endif
    {{-- si le statut est validé,  --}}
    @if (isset($statut))
        <p>DASHBOARD</p>
        adipisicing elit. Fugit similique itaque beatae accusamus natus soluta tempore, minima consequuntur maxime totam
        nisi
        ducimus quam! Magnam repellendus quam amet quod? Nostrum, animi?</p>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit similique itaque beatae accusamus natus soluta
            tempore, minima consequuntur maxime totam nisi ducimus quam! Magnam repellendus quam amet quod? Nostrum, animi?
        </p>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit similique itaque beatae accusamus natus soluta
            tempore, minima consequuntur maxime totam nisi ducimus quam! Magnam repellendus quam amet quod? Nostrum, animi?
        </p>
    @endif
@endsection
