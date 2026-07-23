/*Programmer name: Mr Jason Lim
Program name: dice.js
Description: dice logic implementation 
First written on: Sat, 30-May-2026
Edited on: Tue, 2-June-2026*/
/*======================================================
    DICE.JS
======================================================*/

const DICE_COUNT = 12;
const DICE_MIN = 1;
const DICE_MAX = 20;

let diceList = [];
let hasRolledDice = false;

/*======================================================
    GENERATE DICE
======================================================*/

function rollDice() {

    if (hasRolledDice) {
        return;
    }

    diceList = [];

    for (let i = 0; i < DICE_COUNT; i++) {
        diceList.push({
            id: i,
            value: randomNumber(DICE_MIN, DICE_MAX),
            used: false
        });
    }

    renderDice();

    hasRolledDice = true;
    document
        .getElementById("rollDiceButton")
        .disabled = true;

}


/*======================================================
    RANDOM NUMBER
======================================================*/

function randomNumber(min, max) {

    return Math.floor(Math.random() * (max - min + 1)) + min;

}


/*======================================================
    RENDER DICE
======================================================*/

function renderDice() {

    const container = document.getElementById("diceContainer");

    container.innerHTML = "";

    diceList.forEach(die => {

        const dice = document.createElement("div");

        dice.className = "dice";

        dice.textContent = die.value;

        dice.dataset.id = die.id;

        dice.dataset.value = die.value;

        dice.draggable = !die.used;

        if (die.used) {

            dice.classList.add("used");

        }

        addDiceEvents(dice);

        container.appendChild(dice);

    });

}


/*======================================================
    DRAG EVENTS
======================================================*/

function addDiceEvents(diceElement) {

    diceElement.addEventListener("dragstart", dragStart);

    diceElement.addEventListener("dragend", dragEnd);

}


/*======================================================
    DRAG START
======================================================*/

function dragStart(event) {

    const id = event.target.dataset.id;

    const value = event.target.dataset.value;

    event.dataTransfer.setData("diceId", id);

    event.dataTransfer.setData("diceValue", value);

    event.target.classList.add("dragging");

}


/*======================================================
    DRAG END
======================================================*/

function dragEnd(event) {

    event.target.classList.remove("dragging");

}


/*======================================================
    GET DIE
======================================================*/

function getDie(id) {

    return diceList.find(d => d.id == id);

}


/*======================================================
    MARK USED
======================================================*/

function useDie(id) {

    const die = getDie(id);

    if (!die) return;

    die.used = true;

    renderDice();

}


/*======================================================
    RELEASE DIE
======================================================*/

function releaseDie(id) {

    const die = getDie(id);

    if (!die) return;

    die.used = false;

    renderDice();

}


/*======================================================
    RESET DICE
======================================================*/

function resetDice() {

    diceList.forEach(die => {

        die.used = false;

    });

    renderDice();

}


/*======================================================
    GET VALUE
======================================================*/

function getDiceValue(id) {

    const die = getDie(id);

    if (!die) return 0;

    return die.value;

}


/*======================================================
    CHECK IF ALL USED
======================================================*/

function allDiceUsed() {

    return diceList.every(die => die.used);

}


/*======================================================
    REMOVE ALL
======================================================*/

function clearDice() {

    diceList = [];

    renderDice();

}


/*======================================================
    PUBLIC HELPERS
======================================================*/

function getDiceList() {

    return diceList;

}

function getUnusedDice() {

    return diceList.filter(die => !die.used);

}


/*======================================================
    BUTTON EVENTS
======================================================*/

// document.addEventListener("DOMContentLoaded", () => {

//     const rollButton = document.getElementById("rollDiceButton");

//     const resetButton = document.getElementById("resetButton");

//     if (rollButton) {

//         rollButton.addEventListener("click", () => {

//             rollDice();

//         });

//     }

//     if (resetButton) {

//         resetButton.addEventListener("click", () => {

//             resetDice();

//         });

//     }

// });