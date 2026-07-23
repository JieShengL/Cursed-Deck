<?php
/*Programmer name: Mr Rifqi Syahmi
Program name: settings_function.php
Description: apply setting sidebars
First written on: Sat, 20-June-2026
Edited on: Sat, 20-June-2026*/
$file = "settings.txt";

// Default settings
$defaultSettings = [
    "difficulty" => "normal",
    "show_damage" => 1,
    "tutorial" => 1,
    "autosave" => 1,

    "music" => 70,
    "sfx" => 70,
    "voice" => 70,
    "vibration" => 1,
    "language" => "english",

    "display" => "fullscreen",
    "effects" => "normal",
    "shadows" => "normal",
    "quality" => "high"
];

function loadSettings($file, $defaultSettings)
{
    // If file doesn't exist, then create it
    if (!file_exists($file)) {
        saveSettings($file, $defaultSettings);
        return $defaultSettings;
    }

    $settings = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // FIX: Ensure the line actually contains a '=' before exploding
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode("=", $line, 2);
            // trim() removes accidental trailing spaces or hidden window line endings (\r)
            $settings[trim($key)] = trim($value);
        }
    }

    // Add any missing settings (fallback to defaults if keys don't exist)
    foreach ($defaultSettings as $key => $value) {
        if (!isset($settings[$key])) {
            $settings[$key] = $value;
        }
    }

    return $settings;
}

function saveSettings($file, $settings)
{
    $content = "";

    foreach ($settings as $key => $value) {
        $content .= "$key=$value\n";
    }

    file_put_contents($file, $content);
}
?>