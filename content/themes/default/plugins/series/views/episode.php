<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php include('content/themes/' . THEME . '/includes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="/content/themes/<?php echo THEME ?>/plugins/series/style.css">
<?php
	
	$plugin_data = (object) array_build(\App\Models\PluginData::where('plugin_slug', 'series')->get(), function($key, $data) {
        return array($data->key, $data->value);
    });

    $series_url = (isset($plugin_data->series_url) && $plugin_data->series_url != "") ? $plugin_data->series_url : 'series';
?>

	<link rel="stylesheet" href="<?php echo URL::asset('content/plugins/series/assets/css/style.css') ?>" />
	<script src="<?php echo URL::asset('content/plugins/series/assets/js/vue.min.js') ?>"></script>

	<div class="dimLights"></div>

	<?php $title = (isset($episode->title)) ? $episode->title : $episode->snippet->title; ?>

	<div id="video_title">
		<div class="container">
			<span class="label" style="background:#DB1D1B">You're watching:</span> <h1><?php echo $title ?></h1>
			<div id="video_options">
				<div id="movie_mode" class="btn">
					<i class="dojo-screen-full"></i>Movie Mode
				</div>
				<div id="dim_mode" class="btn">
					<i class="dojo-light-bulb"></i>Dim the Lights
				</div>
			</div>
		</div>
	</div>
	
	<?php $bg_image = (isset($episode->snippet->thumbnails->maxres->url)) ? $episode->snippet->thumbnails->maxres->url : Config::get('site.uploads_url') . '/images/' . $episode->image  ?>

	<div id="video_bg" style="background-image:url(<?php echo $bg_image ?>)">
		<div id="video_bg_overlay"></div>
	

		<div class="container">

			<div class="row">

				<div class="col-md-8" id="left_column" style="padding-right:0px;">
				
					<div id="video_left">

						<?php if(($series->youtube == 1) || $episode->access == 'guest' || ( ($episode->access == 'subscriber' || $episode->access == 'registered') && !Auth::guest() && Auth::user()->subscribed('main')) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $episode->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>

							
								<?php if(($series->youtube == 1) || $episode->type == 'embed'): ?>
									<div id="video_container" class="fitvid">
										<?php if($series->youtube): ?>
											<?php echo $episode->player->embedHtml ?>
										<?php else: ?>
											<?php echo $episode->embed_code ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							

						<?php else: ?>

							<div id="subscribers_only"  style="background-image:url(<?php echo Config::get('site.uploads_url') . '/images/' . $episode->image ?>); background-size:cover">
								<div style="background:rgba(0, 0, 0, 0.5); width:100%; height:100%; position:absolute; left:0px; top:0px; z-index:-1"></div>
								<h2 style="font-size:22px;">Sorry, this episode is only available to <?php if($episode->access == 'subscriber'): ?>Subscribers<?php elseif($episode->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
								<div class="clear"></div>
								<form method="get" action="/signup">
									<button id="button">Signup Now<?php if($episode->access == 'subscriber'): ?> to Become a Subscriber<?php elseif($episode->access == 'registered'): ?> for Free!<?php endif; ?></button>
								</form>
							</div>
						
						<?php endif; ?>

					</div><!-- #video_left -->

				</div><!-- .col-md-8 -->

				<div class="col-md-4" id="right_column" style="margin-left:0px; padding-left:0px;">

					<div id="video_right" style="padding:0px;">

						<?php $sidebar_videos = Video::where('active', '=', '1')->orderByRaw("RAND()")->take(8)->get(); ?>

							<img src="<?php echo ImageHandler::getImage($series->image)  ?>" style="width:100%; height:auto; max-height:60px; min-height:60px;" />

							<div id="episode_sidebar">

								<h3><?php echo $title ?> Episodes</h3>
								<div id="episodes">

									<?php if($series->youtube): ?>
									
											<?php foreach($episodes as $playlist_episode): ?>

												<?php if(isset($playlist_episode->contentDetails)):
														$videoId = $playlist_episode->contentDetails->videoId;
													  else:
													  	$videoId = $playlist_episode->id->videoId;
													  endif;
												?>

												 <div class="content <?php if($videoId == $episode->id): ?>active<?php endif; ?>">
												 	<a href="<?php echo URL::to($series_url) . '/' . $series->slug . '/episode/' . $videoId ?>">
											  			<img src="<?php echo $playlist_episode->snippet->thumbnails->medium->url ?>" />
											  			<p><?php echo $playlist_episode->snippet->title ?></p>
											  			<?php if($videoId == $episode->id): ?>
											  				<div class="label" style="background:#DB1D1B; position:absolute; float:right; position:absolute; left:10px; bottom:10px;"><i class="fa fa-play"></i> playing</div>
											  			<?php endif; ?>
											  			<div style="clear:both"></div>
											  		</a>
												 </div>
											<?php endforeach; ?>

									<?php else: ?>
									
										<div class="vueLoad1">
											<div v-repeat="prev_episodes" class="content">
										  		<a href="<?php echo URL::to($series_url) . '/' . $series->slug . '/episode/' ?>{{ slug }}">
										  			<img src="/content/uploads/images/{{ image | smallImage }}" />
										  			<p>{{ title }}</p>
										  			<div style="clear:both"></div>
										  		</a>

										  	</div>
										 </div>

										 <div class="content active">
										 	<a href="<?php echo URL::to($series_url) . '/' . $series->slug . '/episode/' . $episode->slug ?>">
									  			<img src="<?php echo ImageHandler::getImage($episode->image, "370x220")  ?>" />
									  			<p><?php echo $episode->title ?></p>
									  			<div class="label" style="background:#DB1D1B; position:absolute; float:right; position:absolute; left:10px; bottom:10px;"><i class="fa fa-play"></i> playing</div>
									  			<div style="clear:both"></div>
									  		</a>
										 </div>

										 <div class="vueLoad2">
											<div v-repeat="next_episodes" class="content">
										  		<a href="<?php echo URL::to($series_url) . '/' . $episode->series->slug . '/episode/' ?>{{ slug }}">
										  			<img src="/content/uploads/images/{{ image | smallImage }}" />
										  			<p>{{ title }}</p>
										  			<div style="clear:both"></div>
										  		</a>
										  	</div>
										 </div>

									<?php endif; ?>

								</div>
							</div>
					</div>

				</div>

			</div><!-- .row -->

		</div><!-- .container -->

	</div><!-- #video_bg -->

	<div class="container">

		<div id="left_content">						

			<h3 class="video_title">
				<?php echo $title ?>
			</h3>


			<?php $details = (isset($episode->details)) ? $episode->details : $episode->snippet->description; ?>

			<div class="video-details-container"><?php echo $details ?></div>
			<br />
			<div class="clear"></div>
			<div id="social_share" style="padding:0px;">
		    	<p>Share This Episode:</p>
				<?php include('content/themes/' . THEME . '/partials/social-share.php'); ?>
			</div>

			<div class="clear"></div>

			<div id="comments">
				<div id="disqus_thread"></div>
			</div>

		</div><!-- #left_container -->
	</div>
	
		
	<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'thedevdojo'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the comments</noscript> 

	<script src="<?php echo URL::asset(THEME_URL . '/assets/js/jquery.fitvid.js') ?>"></script>
	<script type="text/javascript">
		var series_episodes = '';

		$(document).ready(function(){
			$('#video_container').fitVids();
			$('.favorite').click(function(){
				if($(this).data('authenticated')){
					$.post('/favorite', { video_id : $(this).data('videoid'), _token: '<?php echo csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
				} else {
					window.location = '/signup';
				}
			});

			$('#movie_mode').click(function(){
				$(this).toggleClass('active');
				$('#left_column').toggleClass('full_column');
				$('#right_column').toggleClass('full_column');
			});

			$('#dim_mode').click(function(){
				$(this).toggleClass('active');
				$('#video_container').toggleClass('bringToFront');
				$('#video_options').toggleClass('static');
				$('.dimLights').fadeToggle();
			});


			<?php if(!$series->youtube): ?>
				series_episodes = new Vue({
			        el: '#episodes',
			        data: {
			          prev_episodes: [],
			          next_episodes: [],
			        },
			      });

				Vue.filter('smallImage', function (value) {
				  // here `input` === `this.userInput`
				  var ext = value.substr(value.lastIndexOf('.')+1)
				  return value.replace('.' + ext, '-small.' + ext);
				})

				getEpisodes();

			<?php else: ?>

					repositionActive();

			<?php endif; ?>

		});

		function getEpisodes(){
			var url = '/api/v1/series/' + <?php echo $series->id ?> + '/episodes/' + '<?php echo $episode->id ?>';
			$.getJSON( url, function( data ) {
				console.log(data);
				series_episodes.$data.prev_episodes = data.prev_episodes;
				series_episodes.$data.next_episodes = data.next_episodes;
				$('.vueLoad1').show();
				$('.vueLoad2').show();
				setTimeout(function(){
					repositionActive();
				}, 1000);
			});
			
		}

		function repositionActive(){
			$('#episodes').scrollTop($('#episodes .content.active').position().top );
		}

	</script>

	<?php if($series->youtube || $episode->type == 'embed'): ?>

		<script>
			$(document).ready(function(){
				// auto play youtube video
				if(typeof($('#video_container iframe').attr('src')) != 'undefined' && $('#video_container iframe').attr('src').indexOf("?") > -1){
					var add_attributes = '&theme=light&autoplay=1';
				} else {
					var add_attributes = '?theme=light&autoplay=1';
				}
				$('#video_container iframe').attr('src', $('#video_container iframe').attr('src') + add_attributes);
			});
		</script>

	<?php else: ?>

		<!-- RESIZING FLUID VIDEO for VIDEO JS -->
		<script type="text/javascript">

			$(document).ready(function(){

			  // Once the video is ready
				_V_("video_player").ready(function(){

					console.log('test');

					var myPlayer = this;    // Store the video object
					var aspectRatio = 9/16; // Make up an aspect ratio

					function resizeVideoJS(){
					console.log(myPlayer.id);
					// Get the parent element's actual width
					var width = document.getElementById('video_container').offsetWidth;
					// Set width to fill parent element, Set height
					myPlayer.width(width).height( width * aspectRatio );
					}

					resizeVideoJS(); // Initialize the function
					window.onresize = resizeVideoJS; // Call the function on resize
			  	});

			});
		</script>

	<?php endif; ?>

	<script src="<?php echo URL::asset(THEME_URL . '/assets/js/rrssb.min.js') ?>"></script>

<?php include('content/themes/' . THEME . '/includes/footer.php'); ?>