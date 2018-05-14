<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="./Home/View/js/jquery-1.11.1.min.js"></script>
    <script src="./Home/View/js/jplayer/js/jquery.jplayer.min.js"></script>
    <link href="./Home/View/js/jplayer/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet">
</head>
<body>
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
    <div class="jp-type-single">
        <div class="jp-gui jp-interface">
            <div class="jp-controls">
                <button class="jp-play" role="button" tabindex="0">play</button>
                <button class="jp-stop" role="button" tabindex="0">stop</button>
            </div>
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
            <div class="jp-volume-controls">
                <button class="jp-mute" role="button" tabindex="0">mute</button>
                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
            </div>
            <div class="jp-time-holder">
                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                <div class="jp-toggles">
                    <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                </div>
            </div>
        </div>
        <div class="jp-details">
            <div class="jp-title" aria-label="title">&nbsp;</div>
        </div>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
<script>
    $(function(){



        $("#jquery_jplayer_1").jPlayer({

            supplied: "m4a, mp3",
            swfPath: "/Home/View/js/jplayer/js/jquery.jplayer.swf",
            supplied: "mp3,m4a",
            volume: 1

        });


        url="http://audio.xmcdn.com/group40/M01/CF/1E/wKgJT1q7J9aQNYzSAGLWgLwBOpU504.m4a"
        $("#jquery_jplayer_1").jPlayer("setMedia", {
            mp3:url,
            m4v:url // Defines the m4v url
        }).jPlayer("play");


    })
</script>
</body>
</html>