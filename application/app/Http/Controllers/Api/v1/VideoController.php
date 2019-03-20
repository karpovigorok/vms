<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php namespace Api\v1;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as Controller;
use \Response as Response;
use \Input as Input;

use \Auth as Auth;
use \App\Models\Setting;
use \VideoCategory as VideoCategory;
use \App\Models\Video;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller {

	private $default_limit = 50;
	private $public_columns = array('id', 'video_category_id', 'type', 'access', 'details', 'description', 'featured', 'duration', 'views', 'image', 'created_at', 'updated_at');
	/**
	 * Show all videos.
	 *
	 * @return Json response
	 */
	public function index()
	{
		$response = Video::where('active', '=', '1');

		if(Input::get('offset')){
			$reponse = $response->skip(Input::get('offset'));
		}

		if( Input::get('filter') && Input::get('order') ){
			$response = $response->orderBy(Input::get('filter'), Input::get('order'));
		} else {
			$response = $response->orderBy('created_at', 'desc');
		}

		if(Input::get('limit')){
			$response = $response->take(Input::get('limit'));
		} else {
			$response = $response->take($this->default_limit);
		}

		return Response::json($response->get($this->public_columns), 200);
	}

	public function video($id)
	{
		$settings = Setting::first();
		$video = Video::find($id);
		
		// If user has access to all the content
		if($video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() && Auth::user()->subscribed('main')) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ){
			$columns = null;
		// Else we need to restrict the columns we return
		} else {
			$columns = $this->public_columns;
		}
		return Response::json(Video::where('id', '=', $id)->get($columns), 200);
	}

	public function video_categories(){
		return Response::json(VideoCategory::orderBy('order')->get(), 200);
	}

	public function video_category($id){
		$video_category = VideoCategory::find($id);
		return Response::json($video_category, 200);
	}

    /**
     * @param $id
     */

	public function video_file_status($id) {
        $video = Video::find($id);
        $response = [
            'process_status' => $video->process_status,
            'convert' => Config::get('site.video.convert'),
        ];
        return Response::json($response, 200);

    }

    public function generate_thumbs($id) {
        $video = Video::findOrFail (intval($id));
        if($video) {
            $thumbs = [];
            $uploaded_video = $video->path .  $video->original_name;
            Log::debug($uploaded_video);
            Log::debug($video->disk);
            Log::debug(Storage::disk($video->disk)->exists($uploaded_video));
            //dd(Storage::disk($video->disk)->exists($uploaded_video));
            if(Storage::disk($video->disk)->exists($uploaded_video)) {
                $media = FFMpeg::fromDisk($video->disk)->open($uploaded_video);
            }
            else {
                $media = FFMpeg::fromDisk($video->disk)->open($video->path . $video->max_height . 'p.mp4');
            }
            if(!is_null($video->duration) && $video->duration > 0) {
                for($i = 0; $i < 5; $i++) {
                    $time_frame_thumb = rand(0, $video->duration);
                    $file_path_name = $video->get_dir_path() . "/thumbs/" . $i . '-' . $time_frame_thumb . '.png';
                    $media->getFrameFromSeconds($time_frame_thumb)
                        ->export()
                        ->toDisk($video->disk)
                        ->save($file_path_name);

                    $file_path_name = Config::get('site.uploads_url') . '/video/' . $file_path_name;
                    $thumbs[] = $file_path_name;
                }
                $response['thumbs'] = $thumbs;
                return Response::json($response, 200);
            }
            else {
                return Response::json(['thumbs'], 200);
            }

        }
    }
}
