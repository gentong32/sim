<?php

function getYouTubeVideoId($url)
{
    $regex = '/[?&]v=([^&]+)/';
    preg_match($regex, $url, $matches);
    return isset($matches[1]) ? $matches[1] : null;
}

function generateThumbnailUrl($videoUrl)
{
    $videoId = getYouTubeVideoId($videoUrl);
    if ($videoId) {
        return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
    } else {
        return ""; // URL video tidak valid
    }
}
