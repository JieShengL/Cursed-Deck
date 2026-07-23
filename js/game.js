/*Programmer name: Mr Jason Lim
Program name: game.js
Description: gameplay flow logic implementation
First written on: Wed, 10-June-2026
Edited on: Sat, 20-June-2026*/
/*======================================================
    GAME.JS
======================================================*/


/*======================================================
    GAME STATE
======================================================*/

let gameStarted = false;
let isGameMenuPaused = false;


/*======================================================
    INITIALIZE GAME
======================================================*/

async function initializeGame() {

    showLoading();

    try {

        await loadBoss(1);

        //await loadCards();

        //rollDice();

        initializeDragDrop();

        resetBattle();

        refreshDamageDisplay();

        gameStarted = true;

        onGameStarted();

    }

    catch (error) {

        console.error(error);

        showError("Failed to initialize game.");

    }

    finally {

        hideLoading();

    }

}


/*======================================================
    START GAME
======================================================*/

async function startGame() {

    await initializeGame();

    //gameStarted = true;

}


/*======================================================
    START LEVEL
======================================================*/

// async function startLevel(level) {

//     showLoading();

//     try {

//         await loadBoss(level);

//         await loadCards();

//         rollDice();

//         initializeDragDrop();

//         resetBattle();

//         refreshDamageDisplay();

//         resetUI();

//     }

//     catch (error) {

//         console.error(error);

//         showError("Unable to load level.");

//     }

//     finally {

//         hideLoading();

//     }

// }
/*======================================================
    PAUSE
======================================================*/
function isPaused() {
    return isGameMenuPaused;
}

/*======================================================
    RESTART LEVEL
======================================================*/

async function restartCurrentLevel() {

    await startLevel(

        getCurrentLevel()

    );

}


/*======================================================
    RESET GAME
======================================================*/

function resetGame() {
    localStorage.removeItem("currentGameCards"); 

    resetCards();
    resetDragDrop();
    resetBattle();
    refreshDamageDisplay();
}

/*======================================================
    ROLL BUTTON
======================================================*/

function handleRollDice() {

    rollDice();

    resetCards();

    refreshDamageDisplay();

    initializeDragDrop();

}


/*======================================================
    RESET BUTTON
======================================================*/

function handleReset() {

    resetGame();

}


/*======================================================
    GAME STATUS
======================================================*/

function isGameStarted() {

    return gameStarted;

}

/*======================================================
    EVENT LISTENERS
======================================================*/

document.addEventListener("DOMContentLoaded", () => {

    const rollButton = document.getElementById("rollDiceButton");
    const pauseButton = document.getElementById("pauseButton");
    const pauseMenu = document.getElementById("pauseMenu");
    const resumeButton = document.getElementById("resumeButton");
    const exitButton = document.getElementById("exitButton");
    const filterSelect = document.getElementById("filterSelect");
    const muteAudioToggle = document.getElementById("muteAudioToggle");

    if (rollButton) {

        rollButton.addEventListener(

            "click",

            handleRollDice

        );

    }


    const resetButton = document.getElementById("resetButton");

    if (resetButton) {

        resetButton.addEventListener(

            "click",

            handleReset

        );

    }


    const attackButton = document.getElementById("attackButton");

    if (attackButton) {

        attackButton.addEventListener(

            "click",

            attackBoss

        );

    }


    const nextLevelButton = document.getElementById(

        "nextLevelButton"

    );

    if (nextLevelButton) {

        nextLevelButton.addEventListener(

            "click",

            () => {

                if (isBossDefeated()) {

                    nextLevel();

                }

                else {

                    restartCurrentLevel();

                }

            }

        );

    }

    if (pauseButton) {
        pauseButton.addEventListener("click", () => {
            isGameMenuPaused = true; 
            pauseMenu.classList.remove("hidden");
        });
    }

    if (resumeButton) {
        resumeButton.addEventListener("click", () => {
            isGameMenuPaused = false; 
            pauseMenu.classList.add("hidden");
        });
    }

    if (exitButton) {
        exitButton.addEventListener("click", () => {
            if (confirm("Are you sure you want to exit to the map? Progress this level will be lost.")) {
                window.location.href = "map.php"; // Redirect back to map dashboard
            }
        });
    }

    if (filterSelect) {
        filterSelect.addEventListener("change", (e) => {
            document.getElementById("game").style.filter = e.target.value;
        });
    }

    if (muteAudioToggle) {
        muteAudioToggle.addEventListener("change", (e) => {
            localStorage.setItem("gameMuted", e.target.checked);
            // can mute them here
            console.log("Audio Muted state:", e.target.checked);
        });
    }

    initializeGame();

});


/*======================================================
    NEW GAME
======================================================*/

async function newGame() {

    currentLevel = 1;

    await startLevel(currentLevel);

}


/*======================================================
    CONTINUE GAME
======================================================*/

async function continueGame() {

    await startLevel(

        getCurrentLevel()

    );

}


/*======================================================
    GAME OVER
======================================================*/

function endGame() {

    gameStarted = false;

    gameFinished();

}


/*======================================================
    GAME WON
======================================================*/

function winGame() {

    gameFinished();

    showSuccess(

        "Congratulations! Boss defeated!"

    );

}


/*======================================================
    GAME LOST
======================================================*/

function loseGame() {

    gameFinished();

    showError(

        "You failed to defeat the boss."

    );

}


/*======================================================
    LEVEL COMPLETE
======================================================*/

function levelCompleted() {

    winGame();

}


/*======================================================
    LEVEL FAILED
======================================================*/

function levelFailed() {

    loseGame();

}


/*======================================================
    PUBLIC HELPERS
======================================================*/

function getGameState() {

    return {

        started: gameStarted,

        paused: isPaused(),

        level: getCurrentLevel(),

        bossHP: getBossHP(),

        bossMaxHP: getBossMaxHP()

    };

}


/*======================================================
    DEBUG
======================================================*/

function printGameState() {

    console.log(

        getGameState()

    );

}