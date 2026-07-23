/*Programmer name: Mr Jason Lim
Program name: dragdrop.js
Description: implementation for drag drop cards logic 
First written on: Fri, 5-June-2026
Edited on: Wed, 10-June-2026*/
/*======================================================
    DRAGDROP.JS
======================================================*/


/*======================================================
    INITIALIZE DRAG & DROP
======================================================*/

function initializeDragDrop() {

    const slots = document.querySelectorAll(".slot");

    slots.forEach(slot => {

        slot.addEventListener("dragover", dragOver);

        slot.addEventListener("dragleave", dragLeave);

        slot.addEventListener("drop", dropDice);

        slot.addEventListener("click", removeDiceFromSlot);

    });

}


/*======================================================
    REFRESH EVENTS
    (Call after cards are generated)
======================================================*/

function refreshDragDrop() {

    initializeDragDrop();

}


/*======================================================
    DRAG OVER
======================================================*/

function dragOver(event) {

    event.preventDefault();

    event.currentTarget.classList.add("dragover");

}


/*======================================================
    DRAG LEAVE
======================================================*/

function dragLeave(event) {

    event.currentTarget.classList.remove("dragover");

}


/*======================================================
    DROP DICE
======================================================*/

function dropDice(event) {

    event.preventDefault();

    const slot = event.currentTarget;

    slot.classList.remove("dragover");


    /* Slot already occupied */

    if (slot.dataset.diceId !== "") {

        return;

    }


    const diceId = event.dataTransfer.getData("diceId");

    const diceValue = event.dataTransfer.getData("diceValue");


    if (diceId === "") {

        return;

    }

    if (slot.classList.contains("filled")) {
    return;
}
    const cardNumber = slot.dataset.card;

    const variable = slot.dataset.variable;


    updateSlot(

        cardNumber,

        variable,

        diceId,

        diceValue

    );


    useDie(Number(diceId));


    updateCardDamage(Number(cardNumber));


    updateTotalDamage();

}


/*======================================================
    REMOVE DICE
======================================================*/

function removeDiceFromSlot(event) {

    const slot = event.currentTarget;

    if (slot.dataset.diceId === "") {

        return;

    }


    const diceId = Number(slot.dataset.diceId);

    const cardNumber = Number(slot.dataset.card);

    const variable = slot.dataset.variable;


    releaseDie(diceId);


    clearSlot(

        cardNumber,

        variable

    );


    updateCardDamage(cardNumber);

    updateTotalDamage();

}


/*======================================================
    ENABLE ALL SLOTS
======================================================*/

function enableSlots() {

    document.querySelectorAll(".slot")

        .forEach(slot => {

            slot.style.pointerEvents = "auto";

        });

}


/*======================================================
    DISABLE ALL SLOTS
======================================================*/

function disableSlots() {

    document.querySelectorAll(".slot")

        .forEach(slot => {

            slot.style.pointerEvents = "none";

        });

}

/*======================================================
    CHECK SLOT STATUS
======================================================*/

function isSlotEmpty(cardNumber, variable) {

    const slot = document.querySelector(

        `.slot[data-card="${cardNumber}"][data-variable="${variable}"]`

    );

    if (!slot) {

        return false;

    }

    return slot.dataset.diceId === "";

}


/*======================================================
    GET SLOT DICE ID
======================================================*/

function getSlotDiceId(cardNumber, variable) {

    const slot = document.querySelector(

        `.slot[data-card="${cardNumber}"][data-variable="${variable}"]`

    );

    if (!slot) {

        return null;

    }

    if (slot.dataset.diceId === "") {

        return null;

    }

    return Number(slot.dataset.diceId);

}


/*======================================================
    GET SLOT ELEMENT
======================================================*/

function getSlotElement(cardNumber, variable) {

    return document.querySelector(

        `.slot[data-card="${cardNumber}"][data-variable="${variable}"]`

    );

}


/*======================================================
    CLEAR ALL SLOTS
======================================================*/

function clearAllSlots() {

    const slots = document.querySelectorAll(".slot");

    slots.forEach(slot => {

        slot.textContent = "";

        slot.dataset.value = "";

        slot.dataset.diceId = "";

        slot.classList.remove("filled");

        slot.classList.remove("dragover");

    });

}


/*======================================================
    RESET DRAG & DROP
======================================================*/

function resetDragDrop() {

    clearAllSlots();

    resetDice();

    updateAllCardDamages();

    updateTotalDamage();

}


/*======================================================
    CHECK IF BOARD COMPLETE
======================================================*/

function isBoardComplete() {

    return areAllCardsComplete() && allDiceUsed();

}


/*======================================================
    LOCK BOARD
======================================================*/

function lockBoard() {

    disableSlots();

    document.querySelectorAll(".dice").forEach(dice => {

        dice.draggable = false;

    });

}


/*======================================================
    UNLOCK BOARD
======================================================*/

function unlockBoard() {

    enableSlots();

    renderDice();

}


/*======================================================
    REATTACH EVENTS
======================================================*/

function attachDragDropEvents() {

    initializeDragDrop();

}


/*======================================================
    INITIALIZE AFTER CARDS ARE LOADED
======================================================*/

document.addEventListener("DOMContentLoaded", () => {

    const observer = new MutationObserver(() => {

        if (document.querySelector(".slot")) {

            initializeDragDrop();

            observer.disconnect();

        }

    });

    observer.observe(

        document.getElementById("cardsSection"),

        {

            childList: true,

            subtree: true

        }

    );

});