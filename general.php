<?php
/*Programmer name: Mr Rifqi Syahmi
Program name: general.php
Description: navigate general settings
First written on: Thurs, 4-June-2026
Edited on: Thurs, 4-June-2026*/
include "settings_function.php";
include "set_sidebar.php";
$settings = loadSettings($file, $defaultSettings);

if(isset($_POST['save']))
{
    $settings["difficulty"] = $_POST["difficulty"];
    $settings["show_damage"] = isset($_POST["show_damage"]) ? 1 : 0;
    $settings["tutorial"] = isset($_POST["tutorial"]) ? 1 : 0;
    $settings["autosave"] = isset($_POST["autosave"]) ? 1 : 0;

    saveSettings($file, $settings);
    echo "<script>alert('Changes saved');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<title>General</title>
</head>
<style>
    #reset{
    height: 40px;
    font-size: 20px;
    background-color: #555;
}
</style>

<body class="container" id="setting">
        <div class="content">
            <form method="post">
                <div class="setcard">Difficulty
                    
                        <select name="difficulty" class="dropdown">
                            <option value="easy"
                            <?=($settings['difficulty']=="easy")?"selected":""?>>Easy</option>

                            <option value="normal"
                            <?=($settings['difficulty']=="normal")?"selected":""?>>Normal</option>

                            <option value="hard"
                            <?=($settings['difficulty']=="hard")?"selected":""?>>Hard</option>
                        </select>
                    
                </div>
                <div class="setcard">Show Damage Number
                    <label class="switch"> 
                        <input type="checkbox" name="show_damage" <?=($settings['show_damage'])?"checked":""?>>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setcard">Show Tutorial
                    <label class="switch"> 
                        <input type="checkbox" name="tutorial" <?=($settings['tutorial'])?"checked":""?>>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="setcard">Auto Save
                    <label class="switch"> 
                        <input type="checkbox" name="autosave" <?=($settings['autosave'])?"checked":""?>>
                        <span class="slider"></span>
                    </label>
                </div>
            
            <input type="submit" name="save" value="SAVE CHANGES" class="button">
            <input type="submit" name="reset" class="button" value="RESET TO DEFAULT" id="reset" 
            onclick="return confirm('Are you sure you want to restore default settings?');">
        </form>
    </div>
</body>
</html>
