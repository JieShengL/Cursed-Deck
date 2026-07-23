/*Programmer name: Mr Jason Lim
Program name: cards.js
Description: implements card logic to system
First written on: Sat, 6-June-2026
Edited on: Thurs, 18-June-2026*/
/*======================================================
    CARDS.JS
======================================================*/

let currentCards = [];

/*======================================================
    LOAD CARDS FROM DATABASE
======================================================*/

async function loadCards() {
    
    try {
        const response = await fetch("php/getCards.php");

        if (!response.ok) {
            throw new Error("Unable to load cards.");
        }

        currentCards = await response.json();

        localStorage.setItem("currentGameCards", JSON.stringify(currentCards));

        renderCards();
        initializeDragDrop();
    }
    catch (error) {
        console.error(error);
        alert("Failed to load operation cards.");
    }
}


/*======================================================
    RENDER CARDS
======================================================*/

function renderCards() {

    const container = document.getElementById("cardsSection");

    container.innerHTML = "";

    currentCards.forEach((card, index) => {

        container.appendChild(createCard(card, index + 1));

    });

}


/*======================================================
    CREATE CARD
======================================================*/

function createCard(card, number) {

    const cardElement = document.createElement("div");

    cardElement.className = "operationCard";

    cardElement.dataset.cardId = card.card_id;

    cardElement.dataset.formula = card.ability;

    cardElement.dataset.display = card.card_name;

    cardElement.dataset.cardNumber = number;



    /* ---------- Formula ---------- */

    const formula = document.createElement("div");

    formula.className = "formula";

    formula.textContent = card.ability; 

    cardElement.appendChild(formula);



    /* ---------- Variables ---------- */

    const variables = document.createElement("div");

    variables.className = "variables";



    ["A", "B", "C"].forEach(variable => {

        variables.appendChild(

            createVariableRow(number, variable)

        );

    });



    cardElement.appendChild(variables);



    /* ---------- Damage ---------- */

    const damage = document.createElement("div");

    damage.className = "cardDamage";



    damage.innerHTML =

        `Damage: <span id="damage${number}">0</span>`;


    cardElement.appendChild(damage);



    return cardElement;

}


/*======================================================
    CREATE VARIABLE ROW
======================================================*/

function createVariableRow(cardNumber, variable) {

    const row = document.createElement("div");

    row.className = "variableRow";



    const label = document.createElement("span");

    label.className = "variableLabel";

    label.textContent = variable;



    const slot = document.createElement("div");

    slot.className = "slot";



    slot.dataset.card = cardNumber;

    slot.dataset.variable = variable;

    slot.dataset.diceId = "";

    slot.dataset.value = "";



    row.appendChild(label);

    row.appendChild(slot);



    return row;

}


/*======================================================
    GET CARD
======================================================*/

function getCard(cardNumber) {

    return currentCards[cardNumber - 1];

}


/*======================================================
    GET ALL CARDS
======================================================*/

function getCurrentCards() {

    return currentCards;

}


/*======================================================
    CARD COUNT
======================================================*/

function getCardCount() {

    return currentCards.length;

}

/*======================================================
    RESET ALL CARDS
======================================================*/

function resetCards() {

    const slots = document.querySelectorAll(".slot");

    slots.forEach(slot => {

        slot.textContent = "";

        slot.dataset.value = "";

        slot.dataset.diceId = "";

        slot.classList.remove("filled");

    });

    for (let i = 1; i <= getCardCount(); i++) {

        updateCardDamage(i);

    }

}


/*======================================================
    UPDATE SLOT
======================================================*/

function updateSlot(cardNumber, variable, diceId, value) {

    const slot = document.querySelector(

        `.slot[data-card="${cardNumber}"][data-variable="${variable}"]`

    );

    if (!slot) return;

    slot.textContent = value;

    slot.dataset.value = value;

    slot.dataset.diceId = diceId;

    slot.classList.add("filled");

}


/*======================================================
    CLEAR SLOT
======================================================*/

function clearSlot(cardNumber, variable) {

    const slot = document.querySelector(

        `.slot[data-card="${cardNumber}"][data-variable="${variable}"]`

    );

    if (!slot) return;

    slot.textContent = "";

    slot.dataset.value = "";

    slot.dataset.diceId = "";

    slot.classList.remove("filled");

}


/*======================================================
    GET SLOT VALUE
======================================================*/

function getSlotValue(cardNumber, variable) {

    const slot = document.querySelector(

        `.slot[data-card="${cardNumber}"][data-variable="${variable}"]`

    );

    if (!slot) return null;

    if (slot.dataset.value === "") return null;

    return Number(slot.dataset.value);

}


/*======================================================
    CHECK CARD COMPLETE
======================================================*/

function isCardComplete(cardNumber) {

    return (

        getSlotValue(cardNumber, "A") !== null &&

        getSlotValue(cardNumber, "B") !== null &&

        getSlotValue(cardNumber, "C") !== null

    );

}


/*======================================================
    GET CARD EXPRESSION
======================================================*/

function getCardExpression(cardNumber) {

    const card = getCard(cardNumber);

    if (!card) return "";

    let expression = card.ability;

    expression = expression.replace(/A/g, getSlotValue(cardNumber, "A"));

    expression = expression.replace(/B/g, getSlotValue(cardNumber, "B"));

    expression = expression.replace(/C/g, getSlotValue(cardNumber, "C"));

    return expression;

}


/*======================================================
    UPDATE DAMAGE
======================================================*/

function updateCardDamage(cardNumber) {

    // try {

    //     const expression = getCardExpression(cardNumber);

    //     console.log("Expression:", expression);

    //     const damage = Math.floor(eval(expression));

    //     damageText.textContent = damage;

    // }
    // catch (error) {

    //     console.error(error);

    //     damageText.textContent = "0";

    // }

    const damageText = document.getElementById(

        "damage" + cardNumber

    );

    if (!damageText) return;

    if (!isCardComplete(cardNumber)) {

        damageText.textContent = "0";

        return;

    }

    try {

        const expression = getCardExpression(cardNumber);

        const damage = Math.floor(eval(expression));

        damageText.textContent = damage;

    }

    catch {

        damageText.textContent = "0";

    }

}


/*======================================================
    UPDATE ALL DAMAGES
======================================================*/

function updateAllCardDamages() {

    for (let i = 1; i <= getCardCount(); i++) {

        updateCardDamage(i);

    }

}


/*======================================================
    GET ALL DAMAGES
======================================================*/

function getCardDamages() {

    const damages = [];

    for (let i = 1; i <= getCardCount(); i++) {

        const value = Number(

            document.getElementById(

                "damage" + i

            ).textContent

        );

        damages.push(value);

    }

    return damages;

}


/*======================================================
    CHECK ALL COMPLETE
======================================================*/

function areAllCardsComplete() {

    for (let i = 1; i <= getCardCount(); i++) {

        if (!isCardComplete(i))

            return false;

    }

    return true;

}


/*======================================================
    INITIALIZE
======================================================*/

document.addEventListener("DOMContentLoaded", () => {

    loadCards();

});