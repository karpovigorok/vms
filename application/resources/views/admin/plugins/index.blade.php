@extends('admin.master')

@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h3><i class="fa fa-plug"></i> <?php echo _i("Plugins");?></h3>
	</div>
	<div class="clear"></div>

	<table class="table plugins">
	    <thead>
	    <tr>
	        <th><?php echo _i("Plugin Name");?></th>
	        <th><?php echo _i("Status");?></th>
	        <th><?php echo _i("Action");?></th>
	    </tr>
	    </thead>
	    <tbody>

	        @foreach($plugins as $plugin)

	            <?php $this_plugin = Plugin::where('slug', '=', $plugin['slug'])->first(); ?>
	           
	                <tr>
	                    <td><h2 style="margin:0px; padding-bottom:0px;">{{ $plugin['name'] }} <span style="font-size:14px;">V.{{ $plugin['version'] }}</span></h2>
	                        <small>{{ $plugin['description'] }}</small>
	                    </td>
	                    @if(!empty($this_plugin->active) && $this_plugin->active == 1) 
	                        <td><p>{{ _i("Active") }}</p></td>
	                        <td><a href="plugin/deactivate/{{ $plugin['slug'] }}" class="btn btn-danger" style="display:inline; float:left; margin-right:10px;">De-activate</a><a href="plugin/{{ $plugin['slug'] }}" class="btn btn-success" data-header="<i class='ion ion-outlet'></i> Plugin Settings" data-section="plugins"><i class="fa fa-cog"></i></a></td>
	                    @else 
	                        <td><p>{{ _i("Inactive") }}</p></td>
	                        <td><a href="plugin/activate/{{ $plugin['slug'] }}" class="btn btn-primary">{{ _i("Activate")}}</a></td>
	                    @endif</p></td>
	                   
	                </tr>

	        @endforeach

	    </tbody>
	</table>

</div><!-- admin-container -->

@stop