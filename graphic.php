<?php
/*Programmer name: Mr Rifqi Syahmi
Program name: graphic.php
Description: navigate graphic setting
First written on: Thurs, 4-June-2026
Edited on: Thurs, 4-June-2026*/
include "settings_function.php";
include "set_sidebar.php";
if(isset($_POST['save']))
{
    $settings = loadSettings($file, $defaultSettings);
    $settings['display'] = $_POST['display'];
    $settings['effects'] = $_POST['effects'];
    $settings['shadows'] = $_POST['shadows'];
    $settings['quality'] = $_POST['quality'];

    saveSettings($file, $settings);

    header("Location: graphic.php?status=saved");
    exit();
}

if(isset($_POST['reset']))
{
    saveSettings($file, $defaultSettings);
    
    header("Location: graphic.php?status=reset");
    exit();
}
$settings = loadSettings($file, $defaultSettings);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Graphic</title>
    <style>
        #reset {
            height: 40px;
            font-size: 20px;
            background-color: #555;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<?php

    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'saved') {
            echo "<script>alert('Changes saved successfully!');</script>";
        } elseif ($_GET['status'] == 'reset') {
            echo "<script>alert('Graphic settings restored to default!');</script>";
        }
    }
?>
<body class="container" id="setting">
    <div class="content">
        <form method="post">
            <div class="setcard">Display Mode
                <label>
                    <select name="display" class="dropdown">
                        <option value="fullscreen" <?=($settings['display']=="fullscreen")?"selected":""?>>Fullscreen</option>
                        <option value="windowed" <?=($settings['display']=="windowed")?"selected":""?>>Windowed</option>
                    </select>
                </label>
            </div>

            <div class="setcard">Effects
                <label>
                    <select name="effects" class="dropdown">
                        <option value="low" <?=($settings['effects']=="low")?"selected":""?>>Low</option>
                        <option value="normal" <?=($settings['effects']=="normal")?"selected":""?>>Normal</option>
                        <option value="high" <?=($settings['effects']=="high")?"selected":""?>>High</option>
                    </select>
                </label>
            </div>

            <div class="setcard">Shadows
                <label>
                    <select name="shadows" class="dropdown">
                        <option value="low" <?=($settings['shadows']=="low")?"selected":""?>>Low</option>
                        <option value="normal" <?=($settings['shadows']=="normal")?"selected":""?>>Normal</option>
                        <option value="high" <?=($settings['shadows']=="high")?"selected":""?>>High</option>
                    </select>
                </label>
            </div>
            
            <div class="setcard">Overall Quality
                <label>
                    <select name="quality" class="dropdown">
                        <option value="low" <?=($settings['quality']=="low")?"selected":""?>>Low</option>
                        <option value="normal" <?=($settings['quality']=="normal")?"selected":""?>>Normal</option>
                        <option value="high" <?=($settings['quality']=="high")?"selected":""?>>High</option>
                        <option value="custom" <?=($settings['quality']=="custom")?"selected":""?>>Custom</option>
                    </select>
                </label>
            </div> 
            
            <div class="button-group">
                <input type="submit" name="save" class="button" value="SAVE CHANGES">
                <input type="submit" name="reset" class="button" value="RESET TO DEFAULT" id="reset" 
                    onclick="return confirm('Are you sure you want to restore default settings?');">
            </div>
        </form>
    </div>
</body>
</html>