
function showShareDialog(id) {
    event.stopPropagation();
    window.addEventListener("keydown", listnerForEscapeShareDialog, false);
    $("#shareDialogBox").text("");
    $("#shareDialogContainer").show();
    addPlayListXML = post("/ajax/shareDialog.php", "musicid=" + id + "&time" + (new Date()).getTime(), true, function() {
        if (this.readyState === 4 && this.status === 200) {
            $("#shareDialogBox").text(this.responseText);
        }
    });
}
function listnerForEscapeShareDialog() {
    if (event.keyCode == 27) {
        window.removeEventListener(listnerForEscapeShareDialog);
        hideShareDialogBox();
    }
}
function hideShareDialogBox() {

    $("#shareDialogContainer").hide();

}

var lastMoved = 0;
var isFullScreenMusicPlaying = false;
function showFullScreenMusic() {
    isFullScreenMusicPlaying = true;
    var w = 787, h = 304;
    if (screen.availWidth > w && screen.availHeight > h) {
        var left = (screen.availWidth - w) / 2;
        var top = (screen.availHeight - h) / 2;
        $("#fullScreenMusicController").css("left:" + left + "px;top:" + top + "px;");
    }
    $("#fullScreenMusic").show();
    var imaSrc = $("#currentPlayingMusicIcon").attr("src");
    $("#fullScreenMusicImage").css("background:url(" + imaSrc + ");background-repeat:no-repeat;background-size:cover;");
    window.addEventListener("mousemove", showOptionFullScreen, false);
    window.addEventListener("keydown", listnerForEscapeFullMusic, false);
    setInterval(checkFullScreenVisibility, 100);
}
function hideFullScreenMusic() {
    isFullScreenMusicPlaying = false;
    $("#fullScreenOption").css("opacity:0");
    $("#fullScreenMusic").hide();
    window.removeEventListener("mousemove", showOptionFullScreen);
}
function checkFullScreenVisibility() {
    if ($("#fullScreenOption").css("opacity") == "0") {
        $("#fullScreenOption").css("opacity:1");
    }
    currentTime = (new Date()).getTime();

    if (currentTime - lastMoved > 1500) {
        $("#fullScreenOption").css("opacity:0;");
    }
}
function showOptionFullScreen() {
    lastMoved = (new Date()).getTime();
}
function fullScreenMusicPlay() {
    if (audio.paused) {
        playSound();
        $("#fullScreenMusicPlayPause").removeClass("sprite-playIcon");
        $("#fullScreenMusicPlayPause").addClass("sprite-pauseIcon");
    } else {
        $("#fullScreenMusicPlayPause").addClass("sprite-playIcon");
        $("#fullScreenMusicPlayPause").removeClass("sprite-pauseIcon");
        pauseSound();
    }
}
function fullScreenMusicNextSound() {
    nextSound();
    var imaSrc = $("#currentPlayingMusicIcon").attr("src");
    $("#fullScreenMusicImage").css("background:url(" + imaSrc + ");background-repeat:no-repeat;background-size:cover;");
}
function fullScreenMusicPreviousSound() {
    previousSound();
    var imaSrc = $("#currentPlayingMusicIcon").attr("src");
    $("#fullScreenMusicImage").css("background:url(" + imaSrc + ");background-repeat:no-repeat;background-size:cover;");
}
function listnerForEscapeFullMusic() {
    if (event.keyCode == 27) {
        window.removeEventListener(listnerForEscapeFullMusic);
        hideFullScreenMusic();
    }
}

function addToPlayList(id) {
    event.stopPropagation();
    window.addEventListener("keydown", listnerForEscapeAddPlaylist, false);

    $("#addPlayListBox").text("");
    $("#addPlayListContainer").show();
    addPlayListXML = post("/ajax/addPlaylistDialog.php", "musicid=" + id, true, function() {
        if (this.readyState === 4 && this.status === 200) {
            $("#addPlayListBox").text(this.responseText);
        }
    });
}
function listnerForEscapeAddPlaylist() {
    if (event.keyCode == 27) {
        window.removeEventListener(listnerForEscapeAddPlaylist);
        hideAddPlayListBox();
    }
}
function hideAddPlayListBox() {
    $("#addPlayListContainer").hide();
}
function createNewPlayList(id) {
    $("#newplayListError").text("");
    playlistname = $("#newPlayListName").val();
    privacy = _("newPlayListPrivacy").checked;

    newPlayListXML = post("/db/createNewPlayList.php", "playlistname=" + playlistname + "&privacy=" + privacy + "&musicid=" + id, true, function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                addMessageBox(0,"Added To PlayList");
                hideAddPlayListBox();
            } else {
                $("#newplayListError").text(jsonObjectResponse.message);
            }
        }
    });
}
function addToExistingPlayList(musicid, playlist) {
    newPlayListXML = post("/db/addToPlayList.php", "playlistname=" + playlist + "&musicid=" + musicid, true, function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                $("#addtoplaylist_" + jsonObjectResponse.musicid + jsonObjectResponse.playlist).hide();
                $("#addedtoplaylist_" + jsonObjectResponse.musicid + jsonObjectResponse.playlist).show();
            } else {
                $("#existingplayListError").text(jsonObjectResponse.message);
            }
        }
    });
}
function removeFromExistingPlayList(musicid, playlist) {
    newPlayListXML = post("/db/removeFromPlayList.php", "playlistname=" + playlist + "&musicid=" + musicid, true, function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                $("#addtoplaylist_" + jsonObjectResponse.musicid + jsonObjectResponse.playlist).show();
                $("#addedtoplaylist_" + jsonObjectResponse.musicid + jsonObjectResponse.playlist).hide();
            } else {
                $("#existingplayListError").text(jsonObjectResponse.message);
            }
        }
    });
}
function changeToCreateNewPlaylist() {

    $("#addToPlayListPopulatedList").show();
    $("#createNewPlayListPopulatedList").hide();

    $("#changeToCreateNewPlaylistBorder").addClass("addPlayListBorderHighlight");
    $("#changeToAddToExistingPlaylistBorder").removeClass("addPlayListBorderHighlight");
}
function changeToAddToExistingPlaylist() {
    $("#addToPlayListPopulatedList").hide();
    $("#createNewPlayListPopulatedList").show();
    $("#changeToAddToExistingPlaylistBorder").removeClass("addPlayListBorderNormal");
    $("#changeToAddToExistingPlaylistBorder").addClass("addPlayListBorderHighlight");
    $("#changeToCreateNewPlaylistBorder").removeClass("addPlayListBorderHighlight");

}
function  showPlaylistSettingOptionDialog(playlistname) {
    $("#playlistSettingOption_" + playlistname).toggle();
}
function deletePlayList(playlistname) {
    var isConfirm = confirm("Are You Sure?");
    if (!isConfirm) {
        return;
    }
    var deletePlayListXML = post("/db/deletePlayList.php", "playlistname=" + playlistname, true, function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                addMessageBox(0,jsonObjectResponse.message);

                initPageLoader(jsonObjectResponse.profilePlaylistURL);
            } else {
                addMessageBox(1,jsonObjectResponse.message);
            }
        }
    });
}
function changePrivacyToPrivatePlayList(playlistname) {
    var changePrivacyPrivatePlayListXML = post("/db/togglePrivacyPlayList.php", "playlistname=" + playlistname + "&playlistprivacy=private", true, function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                addMessageBox(0,jsonObjectResponse.message);
                $("#playlistSettingOptionPublic_" + jsonObjectResponse.playlistname).hide();
                $("#playlistSettingOptionPrivate_" + jsonObjectResponse.playlistname).show();
            } else {
                addMessageBox(1,jsonObjectResponse.message);
            }
        }
    });
}
function changePrivacyToPublicPlayList(playlistname) {
    var changePrivacyPublicPlayListXML = post("/db/togglePrivacyPlayList.php", "playlistname=" + playlistname + "&playlistprivacy=public", true, function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                addMessageBox(0,jsonObjectResponse.message);
                $("#playlistSettingOptionPublic_" + jsonObjectResponse.playlistname).show();
                $("#playlistSettingOptionPrivate_" + jsonObjectResponse.playlistname).hide();

            } else {
                addMessageBox(1,jsonObjectResponse.message);
            }
        }
    });
}
function addToCurrentPLayingPlayList(musicid) {
    mainAudioList.push(musicid);
    mainAudioListTitle.push($("#audio_" + musicid).attr("data-title"));
    audioList.push(musicid);
    if (mainAudioList.length == 1) {
        $("#mediaPlayerContainer").show();
        $("#footer").css("margin-bottom:55px;");
        startNewAudio(musicid);
    }
}

function instantSearch() {

    if (typeof searchXml == "object") {
        searchXml.abort();
    }
    var txt = $("#searchInput").val();
    if (txt != "") {
        $("#outputSearchResult").css("opacity:0.3;");
        searchXml = post("/db/search.php", "search=" + txt, true, function() {
            if (this.readyState === 4 && this.status === 200) {
                $("#outputSearchResult").css("opacity:1;");
                $("#outputSearchResult").text(this.responseText);
                $("#outputSearchResult .musicSortCard > .eh").on("click", handleMusicClick);
                $("#outputSearchResult .musicSortCard > .eh").on("mouseenter", showPlayHover);
                $("#outputSearchResult .musicSortCard > .eh").on("mouseleave", hidePlayHover);
                $("#outputSearchResult .MUSIC_SETTING").on("click", toggleMusicIndivisualSetting);
            }
        });
    }
}
function hideSearchBox() {
    $("#searchBoxShowContiner").css("opacity:0.1;");
    setTimeout(function() {
        $("#searchBoxContainer").hide();
    }, 200);
}
function showSearchBox() {
    window.addEventListener("keydown", listnerForEscape, false);
    $("#searchBoxContainer").show();
    _("searchInput").focus();
    setTimeout(function() {
        $("#searchBoxShowContiner").css("opacity:1;");
    }, 200);
}
function listnerForEscape() {
    if (event.keyCode == 27) {
        window.removeEventListener(listnerForEscape);
        hideSearchBox();
    }
}

//var audio = document.getElementById('audioContoler');

window.addEventListener("scroll", handleScroll);
function handleScroll() {
    if (document.body.scrollTop >= 150) {
        $("#topAudioContainer").show();
        $("#topProfileContainer").show();
        setTimeout(function() {
            $("#topAudioContainer").css("opacity:1;");
            $("#topProfileContainer").css("opacity:1;");
        }, 0);
    } else if (document.body.scrollTop < 150) {
        $("#topAudioContainer").css("opacity:0;");
        $("#topProfileContainer").css("opacity:0;");
        setTimeout(function() {
            if (document.body.scrollTop < 150) {
                $("#topAudioContainer").hide();
                $("#topProfileContainer").hide();
            }
        }, 500);
    }
}

audio = new Audio();
var audioList = new Array();
var mainAudioList = new Array();
var mainAudioListTitle = new Array();
var isRpeatModeOn = false;
audio.addEventListener("timeupdate", updateAudioTime, false);
audio.addEventListener("playing", audioStartedPlaying, false);
audio.addEventListener("pause", audioPausedPlaying, false);
audio.addEventListener("ended", audioEnded, false);
audio.addEventListener("waiting", audioWaitingPlaying, false);
audio.addEventListener("stalled", audioStalledPlaying, false);
function audioStartedPlaying() {
    $("#playBottomButton").hide();
    $("#waitingBottomButton").hide();
    $("#pauseBottomButton").show();
}
function audioPausedPlaying() {
    $("#playBottomButton").show();
    $("#pauseBottomButton").hide();
    $("#waitingBottomButton").hide();
}
function audioWaitingPlaying() {
    $("#playBottomButton").hide();
    $("#pauseBottomButton").hide();
    $("#waitingBottomButton").show();
}
function audioStalledPlaying() {
    e("Sorry! Media is not available.Its Stalled. Please Check Your Internet Connection.");
}
function changeVolumeFromBottom(ele) {
    audio.volume = parseInt(ele.value) / 100;
}
function toggleVolumeBottom() {
    $("#bottomVolumeContainer").toggle();
}
function previousSound()
{
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();
    if (mainAudioList.indexOf(currentPlayListId) > 0) {
        audioList = Array();
        audioList.push(mainAudioList[mainAudioList.indexOf(currentPlayListId) - 1]);
        startNewAudio(mainAudioList[mainAudioList.indexOf(currentPlayListId) - 1]);
    }

}
function nextSound()
{
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();

    if (mainAudioList.indexOf(currentPlayListId) < mainAudioList.length - 1) {
        audioList = Array();
        audioList.push(mainAudioList[mainAudioList.indexOf(currentPlayListId) + 1]);
        startNewAudio(mainAudioList[mainAudioList.indexOf(currentPlayListId) + 1]);
    }

}
function handleMusicClick() {
    musicid = this.getAttribute("data-musicid");
    if (audioList.length > 0) {
        if (musicid == audio.src.split("/").pop().split(".").shift()) {
            if (audio.paused) {
                $("#hoverCardMusic_sprite_" + musicid).attr("class", "sprite sprite-hoverPauseIcon");
                audio.currentTime = audio.currentTime;
                audio.play();
                return;
            } else {
                $("#hoverCardMusic_sprite_" + musicid).attr("class", "sprite sprite-hoverPlayIcon");
                pauseSound();
                return;
            }
        }
    }

    mainAudioList = Array();
    mainAudioListTitle = Array();
    var className = $("#audio_" + musicid).attr("data-playlistclass");
    $("." + className).each(function() {
        mainAudioList.push(this.getAttribute("data-filename"));
    });
    for (i = 0; i < mainAudioList.length; i++) {
        mainAudioListTitle.push($("#audio_" + mainAudioList[i]).attr("data-title"));
    }
    if (audioList.length == 1)
    {
        $("#hoverCardMusic_" + audioList[0]).hide();
    }
    if (audioList.length == 0 || audioList.length == 1) {
        startNewAudio(musicid);
        $("#mediaPlayerContainer").show();
        $("#footer").css("margin-bottom:55px;")
    }
    /*
     if (musicid == audioList[0])
     {
     if (audio.paused) {
     $("#hoverCardMusic_sprite_" + musicid).attr("class", "sprite sprite-hoverPauseIcon");
     playSound();
     } else {
     $("#hoverCardMusic_sprite_" + musicid).attr("class", "sprite sprite-hoverPlayIcon");
     pauseSound();
     }
     }
     */
    audioList[0] = musicid;
    /*
     var toAddToPlayList = true;
     for (i = 0; i < audioList.length; i++) {
     if (audioList[i] == musicid) {
     toAddToPlayList = false;
     }
     }
     if (toAddToPlayList) {
     audioList.push(musicid);
     }
     
     var toAddToPlayList = true;
     for (i = 0; i < mainAudioList.length; i++) {
     if (mainAudioList[i] == musicid) {
     toAddToPlayList = false;
     }
     }
     if (toAddToPlayList) {
     mainAudioList.push(musicid);
     }
     */
}
function playSound()
{
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();
    $("#hoverCardMusic_sprite_" + currentPlayListId).attr("class", "sprite sprite-hoverPauseIcon");
    audio.play();
}
function pauseSound()
{
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();
    $("#hoverCardMusic_sprite_" + currentPlayListId).attr("class", "sprite sprite-hoverPlayIcon");
    audio.pause();
}
function audioEnded()
{
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();
    $("#hoverCardMusic_" + audioList[0]).hide();
    audioList.shift();
    if (isRpeatModeOn && mainAudioList.indexOf(currentPlayListId) == mainAudioList.length - 1) {
        //audioList = mainAudioList.slice();
        audioList = Array();
        audioList.push(mainAudioList[0]);
        startNewAudio(audioList[0]);
    } else
    if (mainAudioList.indexOf(currentPlayListId) != mainAudioList.length - 1) {
        audioList = Array();
        audioList.push(mainAudioList[mainAudioList.indexOf(currentPlayListId) + 1]);
        startNewAudio(audioList[0]);
    }
}
function startNewAudio(musicid) {
    //var extension = musicid.split('.').pop();
    // var source = document.getElementById('audio' + extension.toUpperCase() + 'Source');
    //source.src = '/upload/audio/' + musicid;
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();
    $("#hoverCardMusic_" + currentPlayListId).hide();
    img = $("#audio_" + musicid).attr("data-img");
    title = $("#audio_" + musicid).attr("data-title");
    name = $("#audio_" + musicid).attr("data-name");
    if (title != undefined || title != "undefined" || title == "") {

        $("#currentPlayingMusicIcon").attr("src", img);
        $("#currentPlayingMusicTitle").text(title);
        $("#currentPlayingMusicUploader").text(name);
    }

    $("#hoverCardMusic_" + musicid).show();
    $("#hoverCardMusic_sprite_" + musicid).attr("class", "sprite sprite-hoverPauseIcon");

    post("/db/updateViewCount.php", "musicid=" + musicid, true, function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                $("#currentPlayingMusicIcon").attr("src", jsonObjectResponse.image);
                $("#currentPlayingMusicTitle").text(jsonObjectResponse.title);
                $("#currentPlayingMusicUploader").text(jsonObjectResponse.username);
                audio.src = jsonObjectResponse.music;
                audio.load(); //call this to just preload the audio without playing
                audio.play();
                var currentPlayListId = audio.src.split("/").pop().split(".").shift();
                if (mainAudioList.length > 1) {
                    if (mainAudioList.indexOf(currentPlayListId) == 0)
                        $(".previousSoundBottom").css("opacity:0.6;cursor:not-allowed");
                    else
                        $(".previousSoundBottom").css("opacity:1;cursor:pointer;");

                    if (mainAudioList.indexOf(currentPlayListId) == mainAudioList.length - 1)
                        $(".nextSoundBottom").css("opacity:0.6;cursor:not-allowed");
                    else
                        $(".nextSoundBottom").css("opacity:1;cursor:pointer;");
                }
            }
        }
    });
}

function updateAudioTime()
{
    progress = (audio.currentTime / audio.duration) * 100;
    if (!isNaN(audio.currentTime)) {
        currentTime = secondsToHms(audio.currentTime);
    } else {
        currentTime = "0:00";
    }
    if (!isNaN(audio.duration)) {
        totalDuration = secondsToHms(audio.duration);
    } else {
        totalDuration = "0:00";
    }

    $("#audioCurrentTime").text(currentTime);
    $("#audioEndTime").text(totalDuration);
    $("#audioProgress").css("width:" + progress + "%;");
    if (FULL_MUSIC && FULL_MUSIC_ID == audio.src.split("/").pop().split(".").shift())
        updatePlayedWaveform();
}
function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);
    return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
}

function changeShowTimeOnOverPos()
{
    posistion = event.pageX - document.getElementById("audioProgressContainer").offsetLeft - 30;
    if (posistion >= -30 && posistion <= 270) {
        seekDisplayTime = secondsToHms(((posistion + 30) / 300) * audio.duration);
        $("#showTimeOnhover").text(seekDisplayTime)
        $("#showTimeOnhover").show();
        isNaN(seekDisplayTime)
        $("#showTimeOnhover").css("left:" + posistion + "px;")
    } else {
        $("#showTimeOnhover").hide();
    }
}
function changeAudioPlayTime()
{
    posistion = event.pageX - document.getElementById("audioProgressContainer").offsetLeft - 30;
    if (posistion >= -30 && posistion <= 270) {
        audio.currentTime = ((posistion + 30) / 300) * audio.duration;
        audio.play();
    }
}
function hideShowTimeOnOverPos() {
    $("#showTimeOnhover").hide();
}
function toggleBottomPlayeList() {
    playListContent = "";
    for (i = 0; i < mainAudioList.length; i++) {
        item = mainAudioList[i];
        playListTitle = mainAudioListTitle[i];
        if (audioList.length > 0) {
            if (item == audioList[0]) {
                playListContent += "<li style='background:rgba(120,120,120,0.8);;' onclick='playAudioFromPlaylistClick(\"" + item + "\")'>" + playListTitle + "</li>";
            } else {
                playListContent += "<li onclick='playAudioFromPlaylistClick(\"" + item + "\")'>" + playListTitle + "</li>";
            }
        } else {
            playListContent += "<li onclick='playAudioFromPlaylistClick(\"" + item + "\")'>" + playListTitle + "</li>";
        }
    }
    if (playListContent == "")
    {
        playListContent = "<li>Play List Is Empty</li>";
    }
    $("#bottomPlayList").text(playListContent);
    $("#bottomPlayList").toggle();
}
function playAudioFromPlaylistClick(musicid) {
    event.stopPropagation();
    audioList = new Array();
    /*
     var startAdding = false;
     for (i = 0; i < mainAudioList.length; i++) {
     item = mainAudioList[i];
     if (item == musicid) {
     startAdding = true;
     }
     if (startAdding) {
     audioList.push(item);
     }
     }
     */
    audioList.push(musicid);
    startNewAudio(musicid);
    toggleBottomPlayeList();
    toggleBottomPlayeList();
}
function showPlayHover() {
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();

    id = this.getAttribute("data-musicid");

    if (audio != null) {
        if (audio.paused && id == currentPlayListId && !this.hasOwnProperty("pageloaded")) {
            return;
        }
    }
    $("#hoverCardMusic_" + id).show();
    if (id == currentPlayListId) {
        $("#hoverCardMusic_sprite_" + id).attr("class", "sprite sprite-hoverPauseIcon");
    } else {
        $("#hoverCardMusic_sprite_" + id).attr("class", "sprite sprite-hoverPlayIcon");
    }
    if (this.hasOwnProperty("pageloaded")) {
        if (audio.paused) {
            $("#hoverCardMusic_sprite_" + id).attr("class", "sprite sprite-hoverPlayIcon");
        } else {
            $("#hoverCardMusic_sprite_" + id).attr("class", "sprite sprite-hoverPauseIcon");
        }
    }

}
function hidePlayHover() {
    var currentPlayListId = audio.src.split("/").pop().split(".").shift();
    id = this.getAttribute("data-musicid");
    if (audio != null) {
        if (audio.paused && id == currentPlayListId) {
            return;
        }
    }
    if (id != audioList[0]) {
        $("#hoverCardMusic_" + id).hide();
    }

}

function toggleRepeatModeBottom() {
    isRpeatModeOn = !isRpeatModeOn;
    if (isRpeatModeOn) {
        $("#repeatModeBottom").attr("class", "sprite sprite-repeatIconEnabled_35");
    } else {
        $("#repeatModeBottom").attr("class", "sprite sprite-repeatIcon_35");
    }
}

window.onpopstate = function(e) {
    initPageLoader(window.location.href);
};
homebannercurrentlist = 0;
numberOfHomebanner = 3;
window.addEventListener("load", function() {
    setInterval(startHomeBanner, 7000);
});
/*
 function startHomeBanner() {
 for (i = 0; i < numberOfHomebanner; i++) {
 $("#homebanner" + (i + 1)).css("left:" + ((homebannercurrentlist + i - (numberOfHomebanner - 1)) * 100) + "%;");
 if (homebannercurrentlist == i) {
 $("#homeBannerIndicator" + (i + 1)).css("background:#18F3AD")
 } else {
 $("#homeBannerIndicator" + (i + 1)).css("background:#999")
 }
 }
 homebannercurrentlist++;
 if (homebannercurrentlist > (numberOfHomebanner - 1))
 homebannercurrentlist = 0;
 }
 */

homebannercurrentlist = 1;
function startHomeBanner() {
    $("#homebanner" + (homebannercurrentlist)).css("left:0%");

    for (i = 1; i <= 3; i++) {
        if (i != homebannercurrentlist) {
            $("#homebanner" + (i)).css("left:-100%");
        }
    }
    $("#homebanner" + (homebannercurrentlist - 1)).css("left:100%");

    for (i = 1; i <= 3; i++) {
        if (i == homebannercurrentlist) {
            $("#homeBannerIndicator" + i).removeClass("bannerNumber");
            $("#homeBannerIndicator" + i).addClass("bannerNumberHighlight");
            //$("#homeBannerIndicator" + i).css("background:#18F3AD");
            
        } else{
            $("#homeBannerIndicator" + i).addClass("bannerNumber");
            $("#homeBannerIndicator" + i).removeClass("bannerNumberHighlight");
            //$("#homeBannerIndicator" + i).css("background:#CCC");
        }
    }

    homebannercurrentlist++;
    if (homebannercurrentlist > 3)
        homebannercurrentlist = 1;
}

function toggleMusicIndivisualSetting() {
    try {
        var id = this.getAttribute("data-settingid");
        //var id = $(this).attr("data-settingid");

        $("#" + id).toggle();
    } catch (e) {

    }

}
function chnageIndivisualMusicToPrivate(id) {
    var musicPrivacyChangedXML = post("/db/toggleMusicPrivacy.php", "musicid=" + id + "&privacy=private", true, function() {
        if (this.readyState === 4 && this.status === 200) {

            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                addMessageBox(0,jsonObjectResponse.message);
                $("#settingPublic_" + jsonObjectResponse.musicid).hide();
                $("#settingPrivate_" + jsonObjectResponse.musicid).show();
            } else {
                addMessageBox(1,jsonObjectResponse.message);
            }

        }
    }
    );
}

function chnageIndivisualMusicToPublic(id) {
    var musicPrivacyChangedXML = post("/db/toggleMusicPrivacy.php", "musicid=" + id + "&privacy=public", true, function() {
        if (this.readyState === 4 && this.status === 200) {
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                addMessageBox(0,jsonObjectResponse.message);
                $("#settingPublic_" + jsonObjectResponse.musicid).show();
                $("#settingPrivate_" + jsonObjectResponse.musicid).hide();
            } else {
               addMessageBox(1,jsonObjectResponse.message);
            }
        }
    });
}
function deleteIndivisualMusic(id) {

    var isDeleting = window.confirm("Are You Sure");
    if (isDeleting) {
        var musicDeleteXML = post("/db/deleteMusic.php", "musicid=" + id, true, function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText)
                jsonObjectResponse = JSON.parse(this.responseText);
                if (jsonObjectResponse.status == 1) {
                    addMessageBox(0,jsonObjectResponse.message);
                    $("#musicSortCard_" + jsonObjectResponse.musicid).hide();
                } else {
                   addMessageBox(1,jsonObjectResponse.message);
                }
            }
        });
    }
}
var FULL_MUSIC = false;
var FULL_MUSIC_ID = "";
function startAudioWaveform(musicid)
{
    if (FULL_MUSIC_ID == audio.src.split("/").pop().split(".").shift()) {
        if (audio.paused) {
            audio.currentTime = audio.currentTime;
            audio.play();
            return;
        } else {
            pauseSound();
            return;
        }
    }
    FULL_MUSIC = true;
    audioList = Array();
    audioList[0] = musicid;
    $("#mediaPlayerContainer").show();
    $("#footer").css("margin-bottom:55px;")
    startNewAudio(musicid);
}

function updatePlayedWaveform()
{

    per = (audio.currentTime / audio.duration) * 100;
    mainCanvas = document.getElementById("waveformCanvas");
    playedCanvas = document.getElementById("waveformCanvasPlayed");
    mainCanvasCtx = mainCanvas.getContext("2d");
    playedCanvasCtx = playedCanvas.getContext("2d");
    playedCanvasCtx.clearRect(0, 0, 600, 100);
    var imageData = mainCanvasCtx.getImageData(0, 0, 600 * per * 0.01, 100);
    for (var i = 0; i < imageData.data.length; i += 4)
    {
        if (imageData.data[i] != 0) {
            imageData.data[i] = 255
        }
        if (imageData.data[i + 1] != 0) {
            imageData.data[i + 1] = 120
        }
        if (imageData.data[i + 2] != 0) {
            imageData.data[i + 2] = 0;
        }
    }
    playedCanvasCtx.putImageData(imageData, 0, 0);
}
function seekPlayedWaveformOut() {

    if (FULL_MUSIC && FULL_MUSIC_ID == audio.src.split("/").pop().split(".").shift()) {
        seekCanvasCtx.clearRect(0, 0, 600, 100);
    }
}
function seekFromWaveform() {
    if (FULL_MUSIC && FULL_MUSIC_ID == audio.src.split("/").pop().split(".").shift()) {
        offsetElement = document.getElementById("waveformContainer");
        var x = (event.pageX - offsetElement.offsetLeft);
        perSeek = (x / 600) * 100;
        audio.currentTime = audio.duration * perSeek * 0.01;
    }
}
function seekPlayedWaveform()
{
    if (FULL_MUSIC && FULL_MUSIC_ID == audio.src.split("/").pop().split(".").shift()) {
        mainCanvas = document.getElementById("waveformCanvas");
        seekCanvas = document.getElementById("waveformCanvasSeek");
        mainCanvasCtx = mainCanvas.getContext("2d");
        seekCanvasCtx = seekCanvas.getContext("2d");
        offsetElement = document.getElementById("waveformContainer");
        var x = (event.pageX - offsetElement.offsetLeft);
        perSeek = (x / 600) * 100;
        seekCanvasCtx.clearRect(0, 0, 600, 100);
        var imageData = mainCanvasCtx.getImageData(0, 0, 600 * perSeek * 0.01, 100);
        for (var i = 0; i < imageData.data.length; i += 4)
        {
            if (imageData.data[i] != 0) {
                imageData.data[i] = 120
            }
            if (imageData.data[i + 1] != 0) {
                imageData.data[i + 1] = 255
            }
            if (imageData.data[i + 2] != 0) {
                imageData.data[i + 2] = 0;
            }
        }
        seekCanvasCtx.putImageData(imageData, 0, 0);
    }
}
function updateWaveformCanvas()
{
    var c = document.getElementById("waveformCanvas");
    var ctx = c.getContext("2d");
    var img = document.getElementById("loadedWaveform");
    ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight, 0, 0, 600, 100);
}


var readyStateCheckInterval = setInterval(function() {
    h = screen.availHeight - 51 - 51 - 53;
    $(".page").css("min-height:" + h + "px;");
    if (document.readyState === "complete") {
        clearInterval(readyStateCheckInterval);
        //screenHeight = $("html").css("height");
        // screenHeight = screenHeight.substring(0,screenHeight.length-2);

        initPageLoader(window.location.href);
        $("a").on("click", handleAncherClick);
        
        
    }
}, 10);
function initPageLoader(page) {
    
    
    
    FULL_MUSIC = false;
    FULL_MUSIC_ID = "";
    var temp = new Date().getTime();
    if (typeof xml == "object") {
        xml.abort();
    }
    xml = post("/page/ajaxPageLoader.php", "page=" + page, true, function() {
        if (this.readyState == 4 && this.status == 200) {
            var currentTime = new Date().getTime();
            $(".page").css("opacity:0.1;");
            setTimeout(showPageContent.bind(this), ((currentTime - temp) > 500) ? 0 : 500);
            ;
        } else {
            $("#loaderContiner").show();
        }
        if (this.readyState === 4) {
            setTimeout(function() {
                $("#loaderContiner").hide();
            }, 500);
        }
    });
}
function showPageContent() {
    jsonObjectResponse = JSON.parse(this.responseText);
    $("#loaderContiner").hide();
    var pageid = jsonObjectResponse.pageid;
    if (pageid === 2 || pageid === 3 || pageid === 4) {
        $(".page").css("background:#DDD");
        $("#pageContiner").show();
        $("#fullScreenContent").hide();
        $(".page").text(jsonObjectResponse.content);
    }
    if (pageid === 5) {
        $("#pageContiner").hide();
        $("#fullScreenContent").show();
        $("#fullScreenContent").text(jsonObjectResponse.content);
        //alert(jsonObjectResponse.wavegenrated);
        if (jsonObjectResponse.wavegenrated == "1") {

        }
        FULL_MUSIC = true;
        FULL_MUSIC_ID = jsonObjectResponse.audiofile.split(".").shift();
    } else if (pageid === 6) {
        $("#pageContiner").hide();
        $("#fullScreenContent").show();
        $("#fullScreenContent").text(jsonObjectResponse.content);
    } else {
        if (pageid === 8) {
            $(".LOGGEDIN").hide();
            $(".NOTLOGGEDIN").show();
        }
        $(".page").css("background:#FFF");
        $("#pageContiner").show();
        $("#fullScreenContent").hide();
        $(".page").text(jsonObjectResponse.content);
    }
    $("title").text(jsonObjectResponse.title);
    $(".body a").on("click", handleAncherClick);
    $(".musicSortCard > .eh").on("click", handleMusicClick);
    $(".musicSortCard > .eh").on("mouseenter", showPlayHover);
    $(".musicSortCard > .eh").on("mouseleave", hidePlayHover);
    $(".MUSIC_SETTING").on("click", toggleMusicIndivisualSetting);
    //toggleMusicIndivisualSetting
    tmp = document.getElementsByClassName("autofocus")[0];
    if (typeof tmp != "undefined")
        tmp.focus();
    setTimeout(function() {
        $(".page").css("opacity:1;");
        if (audioList.length != 0) {
            var id = audio.src.split("/").pop().split(".").shift();
            ele = $("#audio_" + id).elements();
            ele = ele[0];
            ele.pageloaded = true;
            var temp = showPlayHover.bind(ele);
            temp();

        }
    }, 200);

}
function handleAncherClick() {
    e("Cass Name " + this.classList);
    if(this.classList=="ancharNewPage"){
        return;
    }
    event.preventDefault();
    initPageLoader(event.target.origin + event.target.getAttribute("href"));
    //p = event.target.hostname.length + 7;
    p = event.target.origin;
    console.log(event);
    changeAddr(event.target.getAttribute("href").substring(p));
    
}

function login() {
    var e = $("#loginName").val();
    t = $("#loginPass").val();
    a = _("logincheckbox").checked;
    if (e == "" || t == "") {
        $("#wrongpassword").text("Enter both username and password");
    } else {
        $("#wrongpassword").text("");
        $("#loginProcessing").show();
        $("#loginButton").css("opacity:0.2");
        $("#loginButton").attr("onclick", "");
        loginXml = post("/db/login.php", "username=" + e + "&pass=" + t + "&remem=" + a, true, function() {
            if (this.readyState == 4 && this.status == 200) {
                jsonObjectResponse = JSON.parse(this.responseText);
                if (jsonObjectResponse.status == 1) {
                    //Successfully Logged in
                    var homePath = window.location.protocol + '//' + window.location.host + "";
                    initPageLoader(homePath);
                    changeAddr(homePath);
                    $(".LOGGEDIN").show();
                    $(".NOTLOGGEDIN").hide();
                    $("#topSettingUsername >  a").attr("href", "/user/" + jsonObjectResponse.username + "/overview");
                    addMessageBox(0,jsonObjectResponse.message);
                } else {
                    $("#wrongpassword").text(jsonObjectResponse.message);
                    
                }
            }
            if (this.readyState == 4) {
                $("#loginProcessing").hide();
                $("#loginButton").css("opacity:1");
                $("#loginButton").attr("onclick", "login()");
            }
        });
    }

}
function signup() {
    var t = $("#signUpName").val(), e = $("#signUpPass").val(), r = $("#signUpConfirm").val();
    if (t == "" || e == "" || r == "") {
        $("#signuperror").text("Username and Password are required.");
        return;
    } else {
        $("#signuperror").text("");
    }
    if (r != e) {
        $("#signuperror").text("Password and Confirm password did not match.");
        return;
    } else {
        $("#signuperror").text("");
    }

    $("#signupProcessing").show();
    $("#signupButton").css("opacity:0.2");
    $("#signupButton").attr("onclick", "");
    signupXMLHttp = post("/db/signup.php", "username=" + t + "&pass=" + e + "", true, function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            jsonObjectResponse = JSON.parse(this.responseText);
            if (jsonObjectResponse.status == 1) {
                //Successfully Signed up
                var loginPath = window.location.protocol + '//' + window.location.host + "/login";
                initPageLoader(loginPath);
                changeAddr(loginPath);
                addMessageBox(0,jsonObjectResponse.message);
            } else {
                $("#signuperror").text(jsonObjectResponse.message);
            }
        }

        if (this.readyState == 4) {
            $("#signupProcessing").hide();
            $("#signupButton").css("opacity:1");
            $("#signupButton").attr("onclick", "signup()");
        }
    });
}
function validateAudioFile() {
    var e = document.getElementById("uploadmusic");
    try {
        if (e == undefined || e.files[0].type == undefined || e.files[0].size == 0) {
            $("#errorMusicUpload").text("Select Sound File.");
            return;
        } else {
            $("#errorMusicUpload").text("");
        }
    } catch (e) {

    }
}
function changeToStepTwo() {
    $("#errorMusicUpload").text("");
    var file = _("uploadmusic").files[0];
    if (file == undefined || file.type == undefined || file.size == 0) {
        $("#errorMusicUpload").text("Select Sound File First.");
        return;
    }
    $("#musictitle").val("" + file.name.split(".").shift())
    $("#uploadStepOne").hide();
    $("#uploadStepTwo").show();
}
function tagChanged() {

}
function changeToStepOne() {
    $("#uploadStepTwo").hide();
    $("#uploadStepOne").show();
}
function uploadMusic() {
    var file = _("uploadmusic").files[0];
    // alert(file.name+" | "+file.size+" | "+file.type);
    if (file == undefined || file.type == undefined || file.size == 0) {
        $("#errorMusicUpload").text("Select Sound File First.");
        return;
    }

    if ($("#musictitle").val().trim() === "") {
        $("#errorMusicUpload").text("Enter Title ");
        return;
    } else {
        $("#errorMusicUpload").text("");
    }

    if ($("#musicUploadTag").val().trim() === "") {
        $("#errorMusicUpload").text("Enter Tag ");
        return;
    } else {
        $("#errorMusicUpload").text("");
    }



    var musicFile = _("musicUploadPic").files[0];
    $("#uploadProcessing").show();
    var privacy = _("newMusicPrivacy").checked;
    var formdata = new FormData();
    formdata.append("audiofile1", file);
    formdata.append("musicfile1", musicFile);
    formdata.append("title", $("#musictitle").val());
    formdata.append("tag", $("#musicUploadTag").val());
    formdata.append("privacy", privacy);
    formdata.append("description", $("#musicUploadDescription").val());
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200)
        {
            console.log(ajax.responseText);
            jsonObjectResponse = JSON.parse(ajax.responseText);
            if (jsonObjectResponse.status == 1) {
                var homePath = window.location.protocol + '//' + window.location.host + "";
                initPageLoader(homePath);
                changeAddr(homePath);
                addMessageBox(0,jsonObjectResponse.message);
            } else {
                $("#errorMusicUpload").text(jsonObjectResponse.message);
            }
        }
    }
    ajax.open("POST", "/upload/upload.php");
    ajax.send(formdata);
}
function stopUploading() {
    ajax.abort();
}
function progressHandler(event) {
    var percent = (event.loaded / event.total) * 100;
    $("#progressBar").css("width:" + (Math.round(percent)) + "%");
    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}
function completeHandler(event) {
    //_("status").innerHTML = event.target.responseText;
    $("#uploadProcessing").hide();
    console.log(ajax.responseText);
}
function errorHandler(event) {
    $("#uploadProcessing").hide();
    $("#errorMusicUpload").hide("Some Unknown Error");
}
function abortHandler(event) {
    $("#uploadProcessing").hide();
    $("#errorMusicUpload").hide("Upload Cancled.");
}
function previewImage() {
    var e = document.getElementById("musicUploadPic");
    try {
        if (e == undefined || e.files[0].type == undefined || e.files[0].size == 0) {
            return;
        }
    } catch (e) {
        $("#imagePreview").attr("src", "/image/defaultMusicIcon.jpg")
    }
    if (e.files && e.files[0]) {
        var r, o, t, a = new FileReader;
        a.onload = function(a) {
            var i = a.target.result, d = document.createElement("img");
            d.src = i, r = d.width, o = d.height, t = e.files[0].size, $("#imagePreview").attr("src", d.src)
        }, a.onerror = function(e) {
            console.error("File could not be read! Code " + e.target.error.code)
        }, a.readAsDataURL(e.files[0])
    }
}
function previewAndUpload() {
    PREVIOUS_IMG_PATH = $("#userProfilePic").attr("src");
    var e = document.getElementById("uploadProfilePicInput");
    try {
        if (e == undefined || e.files[0].type == undefined || e.files[0].size == 0) {
            return;
        }
    } catch (e) {

    }
    if (e.files && e.files[0]) {
        var r, o, t, a = new FileReader;
        a.onload = function(a) {
            var i = a.target.result, d = document.createElement("img");
            d.src = i, r = d.width, o = d.height, t = e.files[0].size, $("#userProfilePic").attr("src", d.src)
        }, a.onerror = function(e) {
            console.error("File could not be read! Code " + e.target.error.code)
        }, a.readAsDataURL(e.files[0])

        //Upload
        $("#profilePicUplodeProgress").show();
        var uploadProfilePicFile = _("uploadProfilePicInput").files[0];
        var formdata = new FormData();
        formdata.append("profilePic", uploadProfilePicFile);
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                jsonObjectResponse = JSON.parse(ajax.responseText);
                if (jsonObjectResponse.status == 1) {
                    addMessageBox(0,jsonObjectResponse.message);
                } else if (jsonObjectResponse.status == 3) {
                    addMessageBox(1,jsonObjectResponse.message);
                } else {
                    $("#userProfilePic").attr("src", PREVIOUS_IMG_PATH);
                }
            }
            if (ajax.readyState == 4)
            {
                $("#profilePicUplodeProgress").hide();
            }
        }
        ajax.open("POST", "/upload/uploadProfilePic.php");
        ajax.send(formdata);
    }

}

function previewAndUploadProfileCover() {
    PREVIOUS_IMG_PATH = "";
    var e = document.getElementById("uploadProfileCoverInput");
    try {
        if (e == undefined || e.files[0].type == undefined || e.files[0].size == 0) {
            return;
        }
    } catch (e) {

    }
    if (e.files && e.files[0]) {
        //Upload
        //$("#profilePicUplodeProgress").show();
        var uploadProfilePicFile = _("uploadProfileCoverInput").files[0];
        var formdata = new FormData();
        formdata.append("profileCover", uploadProfilePicFile);
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                console.log(ajax.responseText);
                jsonObjectResponse = JSON.parse(ajax.responseText);
                if (jsonObjectResponse.status == 1) {
                    $("#userProfileCoverPic").css("background:url(" + jsonObjectResponse.profileCover + ");background-size:cover;background-repeat:no-repeat;");
                }
                else if (jsonObjectResponse.status == 3) {
                   addMessageBox(1,jsonObjectResponse.message);
                } else if (jsonObjectResponse.status == 4) {
                    addMessageBox(1,jsonObjectResponse.message);
                } else {
                    $("#userProfileCoverPic").css("background:" + PREVIOUS_IMG_PATH);
                }
            }
            if (ajax.readyState == 4)
            {
                //$("#profilePicUplodeProgress").hide();
            }
        }
        ajax.open("POST", "/upload/uploadProfileCover.php");
        ajax.send(formdata);
    }
}