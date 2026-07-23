/*Programmer name: Mr Jason Lim
Program name: LR.js
Description: handles user interface logic 
First written on: Fri, 12-June-2026
Edited on: Tue, 23-June-2026*/
/*======================================================
    UI.JS
======================================================*/


/*======================================================
    PAUSE STATE
======================================================*/

let gamePaused = false;


/*======================================================
    INITIALIZE UI
======================================================*/

function initializeUI() {

    initializeButtons();

    initializePauseButton();

}


/*======================================================
    BUTTONS
======================================================*/

function initializeButtons() {

    const rollButton = document.getElementById(

        "rollDiceButton"

    );

    const attackButton = document.getElementById(

        "attackButton"

    );

    const resetButton = document.getElementById(

        "resetButton"

    );


    if (rollButton) {

        rollButton.disabled = false;

    }


    if (attackButton) {

        attackButton.disabled = false;

    }


    if (resetButton) {

        resetButton.disabled = false;

    }

}


/*======================================================
    ENABLE BUTTON
======================================================*/

function enableButton(buttonId) {

    const button = document.getElementById(

        buttonId

    );

    if (!button) {

        return;

    }

    button.disabled = false;

}


/*======================================================
    DISABLE BUTTON
======================================================*/

function disableButton(buttonId) {

    const button = document.getElementById(

        buttonId

    );

    if (!button) {

        return;

    }

    button.disabled = true;

}


/*======================================================
    ENABLE ALL BUTTONS
======================================================*/

function enableAllButtons() {

    enableButton("rollDiceButton");

    enableButton("attackButton");

    enableButton("resetButton");

}


/*======================================================
    DISABLE ALL BUTTONS
======================================================*/

function disableAllButtons() {

    disableButton("rollDiceButton");

    disableButton("attackButton");

    disableButton("resetButton");

}


/*======================================================
    PAUSE BUTTON
======================================================*/

function initializePauseButton() {

    const button = document.getElementById(

        "pauseButton"

    );

    if (!button) {

        return;

    }

    button.addEventListener(

        "click",

        togglePause

    );

}


/*======================================================
    TOGGLE PAUSE
======================================================*/

function togglePause() {

    gamePaused = !gamePaused;


    const button = document.getElementById(

        "pauseButton"

    );


    if (gamePaused) {

        button.textContent =

            "▶ Resume";

        disableAllButtons();

        disableSlots();

    }

    else {

        button.textContent =

            "⏸ Pause";

        enableAllButtons();

        enableSlots();

    }

}


/*======================================================
    SHOW LOADING
======================================================*/

function showLoading() {

    document.body.style.cursor =

        "wait";

}


/*======================================================
    HIDE LOADING
======================================================*/

function hideLoading() {

    document.body.style.cursor =

        "default";

}


/*======================================================
    UPDATE DAMAGE DISPLAY
======================================================*/

function refreshDamageDisplay() {

    updateAllCardDamages();

    updateTotalDamage();

}


/*======================================================
    UPDATE HP DISPLAY
======================================================*/

function refreshBossDisplay() {

    updateBossUI();

}


/*======================================================
    RESET UI
======================================================*/

function resetUI() {

    hideResultPopup();

    enableAllButtons();

    enableSlots();

}


/*======================================================
    DOM READY
======================================================*/

document.addEventListener(

    "DOMContentLoaded",

    () => {

        initializeUI();

    }

);

/*======================================================
    SHOW NOTIFICATION
======================================================*/

function showNotification(message) {

    const notification = document.createElement("div");

    notification.className = "notification";

    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {

        notification.classList.add("fadeOut");

    }, 1800);

    setTimeout(() => {

        notification.remove();

    }, 2200);

}


/*======================================================
    SHOW FLOATING DAMAGE
======================================================*/

function showFloatingDamage(damage) {

    const bossImage = document.getElementById("bossImage");

    if (!bossImage) return;

    const text = document.createElement("div");

    text.className = "floatingDamage";

    text.textContent = "-" + damage;

    bossImage.parentElement.appendChild(text);

    setTimeout(() => {

        text.remove();

    }, 1200);

}


/*======================================================
    SCREEN FLASH
======================================================*/

function flashScreen() {

    document.body.classList.add("damageFlash");

    setTimeout(() => {

        document.body.classList.remove("damageFlash");

    }, 500);

}


/*======================================================
    SHAKE BUTTON
======================================================*/

function shakeButton(buttonId) {

    const button = document.getElementById(buttonId);

    if (!button) return;

    button.classList.remove("shake");

    void button.offsetWidth;

    button.classList.add("shake");

}


/*======================================================
    FADE IN
======================================================*/

function fadeIn(element) {

    if (!element) return;

    element.classList.remove("fadeOut");

    element.classList.add("fadeIn");

}


/*======================================================
    FADE OUT
======================================================*/

function fadeOut(element) {

    if (!element) return;

    element.classList.remove("fadeIn");

    element.classList.add("fadeOut");

}


/*======================================================
    HIGHLIGHT BUTTON
======================================================*/

function highlightButton(buttonId) {

    const button = document.getElementById(buttonId);

    if (!button) return;

    button.style.boxShadow = "0 0 20px gold";

    setTimeout(() => {

        button.style.boxShadow = "";

    }, 800);

}


/*======================================================
    LOCK UI
======================================================*/

function lockUI() {

    disableAllButtons();

    disableSlots();

}


/*======================================================
    UNLOCK UI
======================================================*/

function unlockUI() {

    enableAllButtons();

    enableSlots();

}


/*======================================================
    SHOW ERROR
======================================================*/

function showError(message) {

    alert(message);

}


/*======================================================
    SHOW SUCCESS
======================================================*/

function showSuccess(message) {

    showNotification(message);

}


/*======================================================
    GAME START
======================================================*/

function onGameStarted() {

    unlockUI();

    refreshBossDisplay();

    refreshDamageDisplay();

}


/*======================================================
    GAME OVER
======================================================*/

function gameFinished() {

    lockUI();

}


/*======================================================
    RESET INTERFACE
======================================================*/

function resetInterface() {

    hideResultPopup();

    unlockUI();

    refreshDamageDisplay();

}


/*======================================================
    PUBLIC HELPERS
======================================================*/

function isPaused() {

    return gamePaused;

}

function pauseGame() {

    if (!gamePaused) {

        togglePause();

    }

}

function resumeGame() {

    if (gamePaused) {

        togglePause();

    }

}