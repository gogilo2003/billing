@extends('layouts.app', ['pageSlug' => 'icons'])

@section('title')
	Icons
@endsection

@section('sidebar_left')
	@parent
@endsection

@section('content')
	<div class="row">
	    @foreach ($icons as $icon)
            <div class="col-md-2 text-center font-icon-detail">
                <span class="tim-icons {{ $icon }}" style="font-size: 2rem"></span>
                <p style="font-size: 0.8rem">{{ $icon }}</p>
            </div>
        @endforeach
	</div>
@endsection

@section('navbar')
	@parent
@endsection

@section('styles')
	<style>

	</style>
@endsection

@section('scripts_top')
	<script type="text/javascript">

	</script>
@endsection

@section('scripts_bottom')
	<script type="text/javascript">

	</script>
@endsection
