<html>
    <head>
        <title>Initedit</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="icon" href="/favicon.ico">
        <script type="text/javascript"  src="/js/index.js"></script>
        <style>
            .hl,.vl,body,html{margin:0;padding:0}.hl,.hl>li,.vl{list-style:none}.footer,.header{min-height:50px;background:#FFF}.body,.footer,.header,body,html{background:#FFF}.header,.loadMore{text-align:center}body,html{color:#000;width:100%;height:100%}a{text-decoration:none;color:#000}.hl>li{float:left}.clearFix{clear:both}.header{border-bottom:2px solid #18F3AD;padding:0;font-weight:700;font-family:fantasy}.header .logo{min-width:150px;width:100%;max-width:100%;margin:0 auto;line-height:50px}.footer{border-top:2px solid #18F3AD;padding-top:5px;margin-top:10px}.footer>ul>li{padding-right:10px}.loadMore{padding-top:15px;padding-bottom:15px;border-top:2px solid #666;border-bottom:2px solid #666}.controls>li{display:none}.controls>li>button{width:50px;height:50px;z-index:10;background-color:transparent;outline:0;border:none}.mMusicCard{overflow:visible;padding-bottom:5px}.mMusicCard .imgHolder{position:relative;cursor:pointer}.mMusicCard .img{min-height:150px;min-width:100px;background-repeat:no-repeat}.mMusicCard .title{font-size:.9em;width:150px;overflow:hidden;height:20px}.mMusicCard .username{font-size:.8em}
            .sprite {
                background-image: url(/image/spritesheet.png?1);
                background-repeat: no-repeat;
                display: block;
            }
            .sprite-facebook {
                width: 30px;
                height: 30px;
                background-position: -2px -2px;
            }

            .sprite-google {
                width: 30px;
                height: 30px;
                background-position: -36px -2px;
            }
            .sprite-pauseIcon {
                width: 50px;
                height: 50px;
                background-position: -110px -90px;
            }

            .sprite-playIcon {
                width: 50px;
                height: 50px;
                background-position: -163px -2px;
            }
            .sprite-twitter {
                width: 30px;
                height: 30px;
                background-position: -2px -173px;
            }
        </style>
        <script>
            audio = new Audio();
            audio.addEventListener("playing", audioStartedPlaying, false);
            audio.addEventListener("pause", audioPausedPlaying, false);
            audio.addEventListener("ended", audioEnded, false);
            audio.addEventListener("waiting", audioWaitingPlaying, false);
            function audioPausedPlaying() {
                $("#streaming").hide();
                $("#paused").hide();
                $("#play").show();
            }
            function audioEnded() {
                $("#streaming").hide();
                $("#paused").hide();
                $("#play").hide();
            }
            function audioWaitingPlaying() {
                $("#streaming").show();
                $("#paused").hide();
                $("#play").hide();
            }
            function audioStartedPlaying() {
                $("#streaming").hide();
                $("#paused").show();
                $("#play").hide();
            }
            function playSound(musicid) {
                var currentPlayListId = audio.src.split("/").pop().split(".").shift();
                if (currentPlayListId == musicid) {
                    toggleAudioPlayPause();
                    return;
                }
                startNewAudio(musicid);
            }
            function toggleAudioPlayPause() {
                if (audio.paused) {
                    audio.play();
                } else {
                    audio.pause();
                }
            }
            function startNewAudio(musicid) {
                var currentPlayListId = audio.src.split("/").pop().split(".").shift();
                post("/db/updateViewCount.php", "musicid=" + musicid, true, function() {
                    if (this.readyState === 4 && this.status === 200) {
                        jsonObjectResponse = JSON.parse(this.responseText);
                        if (jsonObjectResponse.status == 1) {
                            audio.src = jsonObjectResponse.music;
                            audio.load();
                            audio.play();
                        }
                    }
                });
            }
            var pageNumber = 0;
            window.addEventListener("load", loadTrendingPage);
            function loadTrendingPage() {
                $("#loadMoreText").hide();
                $("#loadMoreImg").show();
                post("/mobile/page/trending.php", "pagenumber=" + pageNumber, true, function() {
                    if (this.readyState === 4 && this.status === 200) {
                        pageNumber++;
                        $(".loadMore").remove();
                        $(".body").append(this.responseText);
                    }
                    if (this.readyState === 4) {
                        $("#loadMoreText").show();
                        $("#loadMoreImg").hide();
                    }
                }
                );
            }
        </script>

    </head>
    <body>
        <div style="position: fixed;right: 20px;top:25px;z-index: 2;">
            <ul class="vl controls">
                <li id="paused" onclick="toggleAudioPlayPause()"><button class="sprite sprite-pauseIcon "></button></li>
                <li id="play" onclick="toggleAudioPlayPause()"><button class="sprite sprite-playIcon "></button></li>
                <li id="streaming" onclick="toggleAudioPlayPause()"><button style="background:url(/image/loader.gif);background-size:contain;"></button></li>
            </ul>
        </div>
        <ul class="vl">
            <li class="header">
                <ul class="hl" style="width:100%;overflow: hidden;">
                    <li class="logo">Initedit Music</li>
                </ul>
            </li>
            <li class="clearFix"></li>
            <li class="body">
                <h3>Trending</h3>
                <div onclick='loadTrendingPage()' class='loadMore'><div id='loadMoreImg' style='display:block;'><img src='/image/loader.gif' width='50' height='50'/></div></div>

            </li>
            <li class="clearFix"></li>
            <li class="footer">
                <ul class="hl">
                    <li >Follow Us : </li>
                    <li><a href="https://plus.google.com/107451468871433725729/about"  style=" padding:0px;padding-top:10px;"><i class="sprite sprite-google" style="margin-right: 10px;"></i></a></li>
                    <li><a href="https://www.facebook.com/InitEdit"  style=" padding:0px;padding-top:10px;"><i class="sprite sprite-facebook" style="margin-right: 10px;"></i></a></li>
                    <li><a href="https://twitter.com/initedit"  style=" padding:0px;padding-top:10px;"><i class="sprite sprite-twitter" style="margin-right: 10px;"></i></a></li>

                </ul>
            </li>
        </ul>
    </body>
</html>