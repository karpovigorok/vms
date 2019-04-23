<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php
/**
 * Developed by Igor Karpov and Sergey Karpov on 07.01.19 22:31
 * Last modified 06.10.18 22:13
 * Website: https://noxls.net
 * Email: mail@noxls.net
 * Copyright (c) 2019.
 *
 */


//namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\Http\Controllers\Controller as Controller;
Use \App\Jobs\ConvertVideo as ConvertVideo;
use \App\Models\Video;
use \App\Models\AllowedMime;
use \App\Libraries\VMSHelper;

class UploadController extends Controller
{
    /**
     * Handles the file upload
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws UploadMissingFileException
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException
     */
    public function upload(Request $request) {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();



//dd($validator);

//        $mime = $file->getMimeType();
//        print ($mime);
//        $file = Input::file('file');
//        $input = array('uploadfile' => $file);
//        $rules = array( 'uploadfile' => 'mimes:mp4,mov,ogg,qt' );
//        $validator = Validator::make($input, $rules);
//        dd($validator->fails());
//
//        print_r(\Request::all());
//        $validator = Validator::make(\Request::all(), ['video_file'  => 'mimes:mp4,mov,ogg,qt | max:20000']);
//
//        if ($validator->fails()) {
//            //print 'not a video';
//            return response()->json([
//                'error' => _i('not a video'),
//            ], 406);
//        }

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile());
        }

//        $validator = $request->validate([
//            'file' => 'mimetypes:video/h264,application/vnd.apple.mpegurl,application/x-mpegurl,video/3gpp,video/mp4,video/mpeg,video/ogg,video/quicktime,video/webm,video/x-m4v,video/ms-asf,video/x-ms-wmv,video/x-msvideo'
//        ]);
//        return;

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Saves the file to S3 server
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFileToS3($file)
    {
        $fileName = $this->createFilename($file);

        $disk = Storage::disk('s3');
        // It's better to use streaming Streaming (laravel 5.4+)
        $disk->putFileAs('photos', $file, $fileName);

        // for older laravel
        // $disk->put($fileName, file_get_contents($file), 'public');
        $mime = str_replace('/', '-', $file->getMimeType());

        // We need to delete the file when uploaded to s3
        unlink($file->getPathname());

        return response()->json([
            'path' => $disk->url($fileName),
            'name' => $fileName,
            'mime_type' =>$mime
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file)
    {

        // Group files by mime type
        $mime = $file->getMimeType();


        $mime_dir = str_replace('/', '-', $mime);
        // Group files by the date (week
        $dateFolder = date("Y-m-W");


        $allowed_mime_exists = AllowedMime::select('mime','extension')->where('mime', '=', $mime)->where('active', '=', 1)->where('type', '=', 'video')->first();

        $allowed_extensions = AllowedMime::select('extension')->where('active', '=', 1)->where('type', '=', 'video')->groupBy('extension')->get()->toArray();

        $allowed_mimes_string = VMSHelper::convert_multi_array($allowed_extensions);


        if(is_null($allowed_mime_exists)) {
            return response()->json([
                'error' => _i('Uploaded file is not a video. Supported file formats: %s', $allowed_mimes_string),
            ], 422);
        }
        // move the file name
        $file_data = [
            'mime_type' => $mime,
            'disk' => 'video_files',
            'user_id' => Auth::user()->id,
            'process_status' => Config::get('site.video.convert')?0:1,
        ];
        $video = Video::create($file_data);
        $fileName = uniqid() . '.' . $allowed_mime_exists->extension;
        $filePath = $video->get_dir_path() . '/converted/';
        $finalPath = storage_path("video/" . $filePath);

        $file_data = [
            'id' => $video->id,
            'path' => $filePath,
            'original_name' => $fileName,
        ];

        $video->update($file_data);
        $file->move($finalPath, $fileName);
        //dispatch((new ConvertVideo($video))->onQueue('convert_video')->delay(Carbon::now()->addMinutes(10)) );
        //dispatch((new ConvertVideo($video))->onQueue('convert_video') );

        //submit to queue for convert

        if(Config::get('site.video.convert')) {
            $job = new ConvertVideo($video);
            $this->dispatch($job->onQueue('convert_video'));
        }

//        $convert_video_job = ConvertVideo::dispatch($video)->onQueue('convert_video');
//
//        return response()->json($convert_video_job->getResponse());




        return response()->json([
            'id' => $video->id
        ], 201);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file, $unique = true, $real_extension = '')
    {
        $extension = $file->getClientOriginalExtension();
        if($real_extension === '') {
            $real_extension = $extension;
        }
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension
        // Add timestamp hash to name of the file
        if($unique) {
            $filename .= "_" . uniqid() . "." . $real_extension;
        }
        else {
            $filename .= "." . $real_extension;
        }
        return $filename;
    }
}