<?php

interface VideoDownloader {
    public function download($videoId);
}

class YoutubeDownloader implements VideoDownloader {
    public function download($videoId) {
        // Simulate a network call to download the video
        echo "Downloading video with ID: $videoId" . PHP_EOL;
        sleep(2); // Simulate time taken to download
        return "Video content for ID: $videoId" . PHP_EOL;
    }
}

class CachedDownloaderProxy implements VideoDownloader {
    private YoutubeDownloader $realDownloader;
    private array $cache = [];

    public function __construct() {
        $this->realDownloader = new YoutubeDownloader();
    }

    public function download($videoId) {
        if (isset($this->cache[$videoId])) {
            echo "Fetching from cache: $videoId" . PHP_EOL;
            return $this->cache[$videoId];
        }

        echo "Cache miss for video ID: $videoId" . PHP_EOL;
        $content = $this->realDownloader->download($videoId);
        $this->cache[$videoId] = $content;
        return $content;
    }
}

// Client code
$downloader = new CachedDownloaderProxy();
echo $downloader->download("123") . PHP_EOL;
echo $downloader->download("123") . PHP_EOL;
echo $downloader->download("456") . PHP_EOL;
echo $downloader->download("456") . PHP_EOL;
echo $downloader->download("123") . PHP_EOL;
