<?php

declare(strict_types=1);
namespace App\Http\Controllers\youtube;


// require __DIR__ . '/vendor/autoload.php';


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;

class YoutubeController extends Controller
{
    
    public function processVideo() {    

        // dd("Called");
        $yt = new YoutubeDl();
        $yt->setBinPath("\\wsl.localhost\Ubuntu-22.04\usr\local");
        $yt->onProgress(static function (?string $progressTarget, string $percentage, string $size, string $speed, string $eta, ?string $totalTime): void {
            echo "Download file: $progressTarget; Percentage: $percentage; Size: $size";
            if ($speed) {
                echo "; Speed: $speed";
            }
            if ($eta) {
                echo "; ETA: $eta";
            }
            if ($totalTime !== null) {
                echo "; Downloaded in: $totalTime";
            }
        });

        // dd("CAlled");
        $collection = $yt->download(
            Options::create()
                ->downloadPath(storage_path('/'))
                ->url('https://www.youtube.com/watch?v=oDAw7vW7H0c')
        );

        dd($collection);
        foreach ($collection->getVideos() as $video) {
            if ($video->getError() !== null) {
                echo "Error downloading video: {$video->getError()}.";
            } else {
                echo $video->getTitle(); // Will return Phonebloks
                $video->getFile(); // \SplFileInfo instance of downloaded file
            }
        }
    }

}
