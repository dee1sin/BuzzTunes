<div style="
font-family: 'Roboto', sans-serif;" class="uploadBox">
    <div style="text-align: center;  margin-bottom: 25px; padding:30px;   color: grey;font-size: 2em;"><b>Upload Music</b></div>
    <p></p>

    <div id="uploadProcessing" style="display: none;text-align: center;" >
        <div><img src="/image/loader.gif" width="50"/></div> 
        <div id="progressUpload">
            <div>
                <div style="background: #999;width:200px;border: 1px solid #111;margin: 0 auto;">
                    <div  id="progressBar" style="" class="uploadMusicProgress"></div>
                </div>

            </div>
            <div id="status"></div>
        </div>
    </div>
    <div id="errorMusicUpload" class="error"></div>
    <div id="uploadStepOne">

        <p></p>
        <div>Sound File (Only MP3 File)</div>
        <p></p>
        <div>
            <input accept=".mp3" type="file" name="audiofile1" id="uploadmusic" onchange="validateAudioFile()"/>
        </div>
        <p></p>
        <div>
            <input type="button" value="Upload" class="input loginButton"  onclick="changeToStepTwo()()"/>   
        </div> 
    </div>
    <div id="uploadStepTwo" style="display: none;">
        <ul class="vl">
            <li><h2>Information</h2></li>
            <li>
                <ul class="hl" style="overflow: hidden;">
                    <li style="min-width: 300px;    margin-right: 4%;width: 48%;">
                        <p></p>
                        <div style="height: 200px;">
                            <div style="position: relative;height: 200px;text-align: center;">
                                <img src="/image/defaultMusicIcon.jpg" id="imagePreview" style="max-height: 200px;"/>
                                <div style="position: absolute;bottom: 20px;left:35%;background: rgba(30,30,30,0.8);color: #FFF;padding: 5px;cursor: pointer;">
                                    <span>Change Music Pic</span>
                                    <input type="file" id="musicUploadPic" onchange="previewImage()" accept="image/*" class="input" style="cursor: pointer;position: absolute;top:0px;left:0px;opacity: 0;"/>
                                </div>

                            </div>

                        </div>
                        <div>(If Image Is not Selected Then We Will Try To Detect It Automatically.)</div>
                    </li>
                    <li style="min-width: 300px;width: 48%;">
                        <p></p>
                        <div>Title</div>
                        <div><input type="text" name="title" placeholder="Enter Music Title" id="musictitle"  class="input autofocus"/> </div>
                        <p></p>
                        <div>Tags</div>
                        <div><input type="text" placeholder="Enters tags" id="musicUploadTag" class="input" onkeyup="tagChanged()"/></div>
                        <p></p>
                        <div>Music Will Be</div>
                        <p></p>
                        <div>
                            <span>
                                <input type="radio" id="newMusicPrivacy" value="1" name="musicPrivacy" />Private
                            </span>
                            <span>
                                <input type="radio" checked="checked" value="0" name="musicPrivacy" />Public
                            </span>
                        </div>
                        <p></p>
                        <div>Description</div>
                        <div>
                            <textarea style="min-width: 300px;min-height: 200px;" id="musicUploadDescription" class="input">
            
                            </textarea>
                        </div>
                    </li>
                </ul>
            </li>
            <li style="text-align: right;">
                <p></p>
                <input type="button" value="Cancle" style="padding: 5px;background: #DDD;color:#333;" onclick="changeToStepOne()"/>
                <input type="button" value="Save" style="padding: 5px;background: #679e55;color:#FFF;" onclick="uploadMusic()"/>
            </li>
        </ul>
    </div>
</div>