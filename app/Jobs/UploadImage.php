<?php

namespace App\Jobs;


use Intervention\Image\Facades\Image;
use Storage;
use File;
use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadImage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $fileId;

    public function __construct(Channel $channel, $fileId)
    {
        $this->channel= $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get the image
        $path = storage_path(). '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '.png';
        
        //reszie the image

        $kuch = Image::make($path)->encode('png')->fit(40,40,function($c)
        {
            $c->upsize();
        })->save();

        
        //upload the S3
        if (Storage::disk('s3images')->put('profile/' . $fileName, fopen($path,'r+')) )
        {
                    //delete temp file
            File::delete($path);
        }

        //update channel image
        $this->channel->image_filename = $fileName;
        $this->channel->save();
    }
}
