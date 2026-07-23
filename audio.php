<?php
/*Programmer name: Mr Cristhiphon
Program name: audio.php
Description: display audio settings
First written on: Tue, 2-June-2026
Edited on:Wed, 3-June-2026*/
include "settings_function.php";
include "set_sidebar.php";
$settings = loadSettings($file, $defaultSettings);

if(isset($_POST['save']))
{
    $settings['music'] = $_POST['music'];
    $settings['sfx'] = $_POST['sfx'];
    $settings['voice'] = $_POST['voice'];
    $settings['vibration'] = isset($_POST['vibration']) ? 1 : 0;
    /*$settings['language'] = $_POST['language'];*/

    saveSettings($file,$settings);
    echo "<script>alert('Changes saved');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<title>Audio</title>
</head>
<style>
    #reset{
    height: 40px;
    font-size: 20px;
    background-color: #555;
}
</style>

<body class="container", id="setting">
    <div class="content">
        <form method="POST">
            <div class="setcard">
                Music 
                <div class="progress-bar">
                    <input type="range" name="music" value="<?=$settings['music']?>" class="progress-slider">
                </div>
            </div>
            
            <div class="setcard">Sfx
                <div class="progress-bar">
                    <input type="range" name="sfx" value="<?=$settings['sfx']?>" class="progress-slider">
                </div>
            </div>
            
            <div class="setcard">Voice 
                <div class="progress-bar">
                    <input type="range" name="voice" value="<?=$settings['voice']?>" class="progress-slider">
                </div>
            </div>
            <div class="setcard">Vibration
                <label class="switch"> 
                    <input type="checkbox" name="vibration" <?=($settings['vibration'])?"checked":""?>>
                    <span class="slider"></span>
                </label>
            </div>
            
            
            <!--<div class="setcard">Language
                <label>
                    <select name="language" class="dropdown">
                        <option value="english" <?=($settings['language']=="english")?"selected":""?>>English</option>
                        <option value="chinese"<?=($settings['language']=="chinese")?"selected":""?>>Chinese</option>
                        <option value="malay" <?=($settings['language']=="malay")?"selected":""?>>Malay</option>
                    </select>
                </label>
            </div>-->
            <input type="submit" name="save" class="button" value="SAVE CHANGES">
            <input type="submit" name="reset" class="button" value="RESET TO DEFAULT" id="reset" 
            onclick="return confirm('Are you sure you want to restore default settings?');">
        </form>
        </div>
        
    </div>

<script>
const sliders = document.querySelectorAll(".progress-slider");

sliders.forEach(slider => {

    function updateSlider() {
        const value = slider.value;

        slider.style.background = `
            linear-gradient(
                to right,
                #a76e18 0%,
                #a76e18 ${value}%,
                black ${value}%,
                black 100%
            )
        `;
    }

    slider.addEventListener("input", updateSlider);

    // Set initial color when page loads
    updateSlider();
});
</script>
</body>
</html>
