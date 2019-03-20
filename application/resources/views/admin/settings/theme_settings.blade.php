@extends('admin.master')

@section('content')
	

@stop

@section('javascript')

	<script>
		$('#main-admin-content').load('/admin/theme_settings_form', function(){
			$('.color-picker').colorpicker();
		});
	</script>

@stop