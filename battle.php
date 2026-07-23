<?php
/*Programmer name: Mr Khow Yong Jing
Program name: battle.php
Description: display battle screen
First written on: Sat, 6-June-2026
Edited on: Tue, 9-June-2026 */
if (!isset($_GET['map']) || empty(trim($_GET['map']))) {
        header("Location: map.php");
        exit();
    }

    $map = trim($_GET['map']);

$maps = [
    "kings_manse" => [
        "background" => "images/battle/Kings_Manse.png",
        "boss" => [
            "name" => "Royal Guardian",
            "hp" => 100,
            "image" => "images/bosses/Royal_Guardian.png"
        ]
    ],

    "monastery" => [
        "background" => "images/battle/Monastery.png",
        "boss" => [
            "name" => "Fallen Archbishop",
            "hp" => 180,
            "image" => "images/bosses/Fallen Archbishop.png"
        ]
    ],

    "sanctum" => [
        "background" => "images/battle/Sanctum.png",
        "boss" => [
            "name" => "Sanctum Warden",
            "hp" => 260,
            "image" => "images/bosses/Sanctum Warden.png"
        ]
    ],

    "miretown" => [
        "background" => "images/battle/The_Mire_Town.png",
        "boss" => [
            "name" => "Plague Stalker",
            "hp" => 350,
            "image" => "images/bosses/Plague Stalker.png"
        ]
    ],

    "whitewoods" => [
        "background" => "images/battle/The White Woods.png",
        "boss" => [
            "name" => "Thornhide Behemoth",
            "hp" => 350,
            "image" => "images/bosses/Thornhide Behemoth.png"
        ]
    ]
];

if (!isset($maps[$map])) {
    header("Location: map.php");
    exit();
}

$current = $maps[$map];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Math Arena</title>

    <link rel="stylesheet" href="css/battle.css">
    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/animations.css">

</head>

<body>

<div id="game">

    <!-- ========================================= -->
    <!-- Arena -->
    <!-- ========================================= -->

    <div id="arena">

        <img id="arenaBackground" src="<?php echo $current['background']; ?>" alt="Arena">

    </div>


    <!-- ========================================= -->
    <!-- Pause -->
    <!-- ========================================= -->

    <button id="pauseButton">

        ⏸ Pause

    </button>

    <!-- ========================================= -->
    <!-- Pause Menu Overlay -->
    <!-- ========================================= -->
    <div id="pauseMenu" class="hidden">
        <div id="pauseContent">
            <h2>Game Paused</h2>

            <!-- Actions Section -->
            <div class="pauseActions">
                <button id="resumeButton">▶ Resume</button>
                <button id="exitButton">Exit to Map</button>
            </div>
        </div>
    </div>

    <!-- ========================================= -->
    <!-- Boss -->
    <!-- ========================================= -->

    <section id="bossSection">

        <h2 id="bossName"></h2>

        <h2 id="bossRank"></h2>

        <div id="bossHPContainer">

            <div id="bossHPBar"></div>

            <span id="bossHPText">

            </span>

        </div>

        <div id="bossImageContainer">

            <img id="bossImage" alt="Boss">

        </div>

    </section>


    <!-- ========================================= -->
    <!-- Dice -->
    <!-- ========================================= -->

    <aside id="dicePanel">

        <h3>Dice</h3>

        <div id="diceContainer">

            <!-- JS generates 12 dice -->

        </div>

    </aside>


    <!-- ========================================= -->
    <!-- Total Damage -->
    <!-- ========================================= -->

    <section id="damagePanel">

        <h3>Total Damage</h3>

        <div id="totalDamage">

            0

        </div>

    </section>


    <!-- ========================================= -->
    <!-- Cards -->
    <!-- ========================================= -->

    <section id="cardsSection">

        <!-- //Card 1

        <div class="operationCard" data-card="1">

            <div class="formula">

                A + B + C

            </div>

            <div class="variables">

                <div class="variableRow">

                    <span class="variableLabel">

                        A

                    </span>

                    <div
                        class="slot"
                        data-card="1"
                        data-variable="A">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">

                        B

                    </span>

                    <div
                        class="slot"
                        data-card="1"
                        data-variable="B">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">

                        C

                    </span>

                    <div
                        class="slot"
                        data-card="1"
                        data-variable="C">

                    </div>

                </div>

            </div>

            <div class="cardDamage">

                Damage:

                <span id="damage1">

                    0

                </span>

            </div>

        </div>





        //Card 2

        <div class="operationCard" data-card="2">

            <div class="formula">

                (A + B) × C

            </div>

            <div class="variables">

                <div class="variableRow">

                    <span class="variableLabel">A</span>

                    <div class="slot"
                        data-card="2"
                        data-variable="A">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">B</span>

                    <div class="slot"
                        data-card="2"
                        data-variable="B">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">C</span>

                    <div class="slot"
                        data-card="2"
                        data-variable="C">

                    </div>

                </div>

            </div>

            <div class="cardDamage">

                Damage:

                <span id="damage2">

                    0

                </span>

            </div>

        </div>





        //Card 3

        <div class="operationCard" data-card="3">

            <div class="formula">

                A × B - C

            </div>

            <div class="variables">

                <div class="variableRow">

                    <span class="variableLabel">A</span>

                    <div class="slot"
                        data-card="3"
                        data-variable="A">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">B</span>

                    <div class="slot"
                        data-card="3"
                        data-variable="B">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">C</span>

                    <div class="slot"
                        data-card="3"
                        data-variable="C">

                    </div>

                </div>

            </div>

            <div class="cardDamage">

                Damage:

                <span id="damage3">

                    0

                </span>

            </div>

        </div>





        //Card 4

        <div class="operationCard" data-card="4">

            <div class="formula">

                A + (B × C)

            </div>

            <div class="variables">

                <div class="variableRow">

                    <span class="variableLabel">A</span>

                    <div class="slot"
                        data-card="4"
                        data-variable="A">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">B</span>

                    <div class="slot"
                        data-card="4"
                        data-variable="B">

                    </div>

                </div>

                <div class="variableRow">

                    <span class="variableLabel">C</span>

                    <div class="slot"
                        data-card="4"
                        data-variable="C">

                    </div>

                </div>

            </div>

            <div class="cardDamage">

                Damage:

                <span id="damage4">

                    0

                </span>

            </div>

        </div> -->

    </section>



    <!-- ========================================= -->
    <!-- Controls -->
    <!-- ========================================= -->

    <section id="controlPanel">

        <button id="rollDiceButton">

            🎲 Roll Dice

        </button>

        <button id="attackButton">

            ⚔ Attack

        </button>

        <button id="resetButton">

            ↺ Reset

        </button>

    </section>



    <!-- ========================================= -->
    <!-- Result Popup -->
    <!-- ========================================= -->

    <div id="resultPopup" class="hidden">

        <div id="popupContent">

            <h2 id="resultTitle">

                Victory

            </h2>

            <p id="resultMessage">

                You defeated the boss!

            </p>

            <button id="nextLevelButton">

                Continue

            </button>

        </div>

    </div>

</div>

<script>
    const mapData = <?php echo json_encode($current); ?>;
</script>   

<script src="js/cards.js"></script>
<script src="js/dice.js"></script>
<script src="js/dragdrop.js"></script>
<script src="js/battle.js"></script>
<script src="js/ui.js"></script>
<script src="js/game.js"></script>

</body>
</html>                    