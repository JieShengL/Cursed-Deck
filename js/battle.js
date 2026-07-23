/*Programmer name: Mr Jason Lim
Program name: battle.js
Description: battle flow logic implementation
First written on: Tue, 2-June-2026
Edited on: Tue, 9-June-2026*/
/*======================================================
    BATTLE.JS
======================================================*/


/*======================================================
    BOSS DATA
======================================================*/

let boss = {

    id: 0,

    name: "",

    hp: 0,

    maxHP: 0,

    image: "",

    rank: 0

};



/*======================================================
    LOAD BOSS
======================================================*/

// async function loadBoss(level = 1) {

//     try {

//         const response = await fetch(

//             "php/getBoss.php?level=" + level

//         );

//         if (!response.ok) {

//             throw new Error("Unable to load boss.");

//         }

//         boss = await response.json();

//         boss.maxHP = boss.hp;

//         updateBossUI();

//     }

//     catch (error) {

//         console.error(error);

//         alert("Failed to load boss.");

//     }

// }

/*======================================================
    LOAD BOSS (HARDCODED)
======================================================*/

async function loadBoss(level) {

    boss = {
        id: level,
        name: mapData.boss.name,
        hp: mapData.boss.hp,
        maxHP: mapData.boss.hp,
        image: mapData.boss.image,
        rank: level
    };
    boss.id = level;
    const multiplier = Math.pow(1.5, level - 1);
    boss.hp = Math.floor(boss.hp * multiplier);
    boss.maxHP = boss.hp;
    boss.rank = level;
    updateBossUI();
}

/*======================================================
    GET BOSS
======================================================*/

function getBoss() {

    return boss;

}



/*======================================================
    TOTAL DAMAGE
======================================================*/

function calculateTotalDamage() {

    const damages = getCardDamages();

    let total = 0;

    damages.forEach(value => {

        total += Number(value);

    });

    return total;

}



/*======================================================
    UPDATE TOTAL DAMAGE
======================================================*/

function updateTotalDamage() {

    const total = calculateTotalDamage();

    const damagePanel = document.getElementById(

        "totalDamage"

    );

    damagePanel.textContent = total;

    damagePanel.classList.remove("damageFlash");

    void damagePanel.offsetWidth;

    damagePanel.classList.add("damageFlash");

}



/*======================================================
    ATTACK
======================================================*/

function attackBoss() {

    if (!isBoardComplete()) {

        alert(

            "Please place all 12 dice before attacking."

        );

        return;

    }

    const damage = calculateTotalDamage();

    //console.log("Damage =", damage);

    boss.hp -= damage;

    if (boss.hp < 0) {

        boss.hp = 0;

    }

    updateBossUI();

    playBossHitAnimation();
    
    showFloatingDamage(damage);

    setTimeout(() => {

        checkBattleResult();

    }, 600);

}



/*======================================================
    HP PERCENTAGE
======================================================*/

function getBossHPPercentage() {

    if (boss.maxHP === 0) {

        return 0;

    }

    return (

        boss.hp /

        boss.maxHP

    ) * 100;

}



/*======================================================
    UPDATE HP BAR
======================================================*/

function updateBossHPBar() {

    const hpBar = document.getElementById(

        "bossHPBar"

    );

    const hpText = document.getElementById(

        "bossHPText"

    );

    hpBar.style.width =

        getBossHPPercentage() + "%";

    hpText.textContent =

        boss.hp +

        " / " +

        boss.maxHP;

}



/*======================================================
    PLAY HIT ANIMATION
======================================================*/

function playBossHitAnimation() {

    const image = document.getElementById(

        "bossImage"

    );

    image.classList.remove("bossHit");

    void image.offsetWidth;

    image.classList.add("bossHit");

}



/*======================================================
    RESET DAMAGE PANEL
======================================================*/

function resetBattle() {

    document.getElementById(

        "totalDamage"

    ).textContent = "0";

}

/*======================================================
    CHECK BATTLE RESULT
======================================================*/

function checkBattleResult() {

    if (boss.hp <= 0) {

        victory();
        //console.log(boss.hp);

    }

    else {

        defeat();

    }

}

/*======================================================
    SAVE GAME
======================================================*/

async function saveGame(outcome) {

    try{
        const data = {

            level: currentLevel,

            result: "Level " + currentLevel + ": " + outcome,

        };

        await fetch("php/saveGame.php", {

            method: "POST",

            headers: {

                "Content-Type": "application/json"

            },

            body: JSON.stringify(data)

        });
    } catch (error) {

        console.error("Failed to save match history:", error);

    }
}

/*======================================================
    VICTORY
======================================================*/

function victory() {

    lockBoard();

    const bossImage = document.getElementById(

        "bossImage"

    );

    bossImage.classList.add(

        "defeated"

    );

    saveGame("Victory");

    showResultPopup(

        "Victory!",

        "You defeated the boss!"

    );

}


/*======================================================
    DEFEAT
======================================================*/

function defeat() {

    lockBoard();

    saveGame("Defeat");

    showResultPopup(

        "Defeat",

        "The boss still has HP remaining."

    );

}


/*======================================================
    SHOW RESULT POPUP
======================================================*/

function showResultPopup(title, message) {

    const popup = document.getElementById(

        "resultPopup"

    );

    const popupTitle = document.getElementById(

        "resultTitle"

    );

    const popupMessage = document.getElementById(

        "resultMessage"

    );

    popupTitle.textContent = title;

    popupMessage.textContent = message;

    popup.classList.remove(

        "hidden"

    );

}


/*======================================================
    HIDE RESULT POPUP
======================================================*/

function hideResultPopup() {

    document.getElementById(

        "resultPopup"

    ).classList.add(

        "hidden"

    );

}


/*======================================================
    NEXT LEVEL
======================================================*/

let currentLevel = 1;
const MAX_LEVEL = 5; 

function nextLevel() {
    if (currentLevel >= MAX_LEVEL) {
        window.location.href = "victory.php";
        return;
    }

    localStorage.removeItem("currentGameCards"); 

    currentLevel++;
    hideResultPopup();
    startLevel(currentLevel);
}


/*======================================================
    RESTART CURRENT LEVEL
======================================================*/

function restartLevel() {

    hideResultPopup();

    startLevel(currentLevel);

}


/*======================================================
    START LEVEL
======================================================*/

async function startLevel(level) {

    currentLevel = level;

    resetBattle();

    resetCards();

    resetDragDrop();

    await loadBoss(level);

    await loadCards();

}


/*======================================================
    UPDATE BOSS UI
======================================================*/

function updateBossUI() {

    document.getElementById("bossName").textContent = boss.name;

    document.getElementById("bossRank").textContent =`Rank ${toRoman(boss.rank)}`;

    document.getElementById("bossImage").src = boss.image;

    updateBossHPBar();

}


/*======================================================
    ATTACK BUTTON
======================================================*/

document.addEventListener(

    "DOMContentLoaded",

    () => {

        const attackButton =

            document.getElementById(

                "attackButton"

            );

        if (attackButton) {

            attackButton.addEventListener(

                "click",

                attackBoss

            );

        }

    }

);


/*======================================================
    NEXT LEVEL BUTTON
======================================================*/

document.addEventListener(

    "DOMContentLoaded",

    () => {

        const nextButton =

            document.getElementById(

                "nextLevelButton"

            );

        if (nextButton) {

            nextButton.addEventListener(

                "click",

                () => {

                    if (boss.hp <= 0) {

                        nextLevel();

                    }

                    else {

                        restartLevel();

                    }

                }

            );

        }

    }

);


/*======================================================
    PUBLIC HELPERS
======================================================*/

function getCurrentLevel() {

    return currentLevel;

}

function getBossHP() {

    return boss.hp;

}

function getBossMaxHP() {

    return boss.maxHP;

}

function isBossDefeated() {

    return boss.hp <= 0;

}

/*======================================================
    ROMAN NUMBERS CONVERTER
======================================================*/
function toRoman(number) {

    const romans = [
        "",
        "I",
        "II",
        "III",
        "IV",
        "V",
        "VI",
        "VII",
        "VIII",
        "IX",
        "X"
    ];

    if (number < romans.length)
        return romans[number];

    return number;

}