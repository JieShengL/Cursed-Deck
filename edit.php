<?php
/*Programmer name: Mr Jason Lim
Program name: edit.php
Description: allows players to reset, save, and edit deck before battle
First written on: Wed, 3-June-2026
Edited on: Sat, 6-June-2026*/
include "dbConn.php";
session_start();

// Protect page: redirect to login if user session is invalid or missing
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['map']) || empty(trim($_GET['map']))) {
    header("Location: map.php");
    exit();
}

$map = trim($_GET['map']);

$mapTitles = [
    'kings_manse'    => "King's Manse",
    'monastery'      => 'Monastery',
    'sanctum'        => 'Sanctum',
    'miretown'       => 'Miretown',
    'whitewoods'     => 'Whitewoods',
    'barredgate'     => 'Barred Gate',
    'ancientruins'   => 'Ancient Ruins',
    'abandonment'    => 'Abandonment',
    'oldmine'        => 'Old Mine',
    'hoarfrostridge' => 'Hoarfrost Ridge'
];

if (!array_key_exists($map, $mapTitles)) {
    header("Location: map.php");
    exit();
}

$currentUser = (int)$_SESSION['user_id']; 
$txt_file_path = "cardsInventory/user_" . $currentUser . "_cards.txt";

$owned_cards = [];

if (file_exists($txt_file_path)) {
    $owned_cards = array_map('trim', file($txt_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
}


if (!empty($owned_cards)) {
    $escaped_cards = array_map(function($card_name) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $card_name) . "'";
    }, $owned_cards);
    
    $card_list_string = implode(",", $escaped_cards);
    
    $query_str = "SELECT * FROM card WHERE card_name IN ($card_list_string) ORDER BY card_id";
    $cardQuery = mysqli_query($conn, $query_str);
} else {
    $cardQuery = mysqli_query($conn, "SELECT * FROM card WHERE 1=0");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Battle Deck - Edit</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            color: white;
            font-family: 'RingBearer', 'Georgia', serif;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1.main-title {
            font-size: 4.5rem;
            color: #ffcc00; 
            text-shadow: 3px 3px 6px rgba(255, 204, 0, 0.2);
            margin: 0 0 40px 0;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1 class="main-title">Battle Deck</h1>

    <div class="deck-slots-container">
        <div class="card-slot" data-slot="1"></div>
        <div class="card-slot" data-slot="2"></div>
        <div class="card-slot" data-slot="3"></div>
        <div class="card-slot" data-slot="4"></div>
    </div>

    <div class="controls-container">
        <button class="btn btn-reset" onclick="resetDeck()">Reset Deck</button>
        <button class="btn btn-save" onclick="saveActiveDeck()">Save Deck</button>
        
        <a href="preparation.php?map=<?php echo urlencode($map); ?>" class="btn btn-exit">back</a>
    </div>

    <div class="inventory-vault">

        <?php 
        if (mysqli_num_rows($cardQuery) > 0) {
            while($card = mysqli_fetch_assoc($cardQuery)) { 
                $clean_image = trim($card['card_image']);
            ?>
            <div class="battle-card"
                draggable="true"
                data-card-id="<?php echo $card['card_id']; ?>"
                style="background-image:url('images/cardImage/<?php echo htmlspecialchars($clean_image); ?>');">

                <!-- <div class="card-name">
                    <?php echo htmlspecialchars($card['card_name']); ?>
                </div> -->

            </div>
            <?php 
            } 
        } else {
        ?>
            <div style="text-align: center; color: #aaa; padding: 20px; width: 100%; font-family: sans-serif;">
                You don't own any cards to build a deck with yet! Clear stages or claim rewards first.
            </div>
        <?php } ?>

    </div>

    <script>
        const cards = document.querySelectorAll(".battle-card");
        const slots = document.querySelectorAll(".card-slot");

        let draggedCard = null;

        document.querySelectorAll(".battle-card").forEach(card => {
            card.addEventListener("dragstart", function () {
                draggedCard = this;
            });
        });

        document.querySelectorAll(".card-slot").forEach(slot => {
            slot.addEventListener("dragover", function(e){
                e.preventDefault();
            });
            slot.addEventListener("drop", function(e){
                e.preventDefault();
                if(slot.firstElementChild){
                    document.querySelector(".inventory-vault")
                            .appendChild(slot.firstElementChild);
                }
                slot.appendChild(draggedCard);
            });
        });

        let autoScroll = null;

        document.addEventListener("dragover", function (e) {

            const scrollMargin = 100;   
            const scrollSpeed = 15;     

            clearInterval(autoScroll);


            if (e.clientY < scrollMargin) {

                autoScroll = setInterval(() => {
                    window.scrollBy(0, -scrollSpeed);
                }, 20);

            }

            else if (window.innerHeight - e.clientY < scrollMargin) {

                autoScroll = setInterval(() => {
                    window.scrollBy(0, scrollSpeed);
                }, 20);

            }

        });

        document.addEventListener("dragend", function () {
            clearInterval(autoScroll);
        });

        document.addEventListener("drop", function () {
            clearInterval(autoScroll);
        });

        function resetDeck(){
            const vault = document.querySelector(".inventory-vault");
            document.querySelectorAll(".card-slot").forEach(slot=>{
                if(slot.firstElementChild){
                    vault.appendChild(slot.firstElementChild);
                }
            });
        }

        async function saveActiveDeck() {
            let deck = [];
            document.querySelectorAll(".card-slot").forEach(slot => {
                if (slot.firstElementChild) {
                    deck.push(slot.firstElementChild.dataset.cardId);
                }
            });

            if (deck.length != 4) {
                alert("Please choose exactly 4 cards.");
                return;
            }

            try {
                const response = await fetch("saveDeck.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ deck: deck })
                });

                const result = await response.json();
                console.log(result);
                if (result.success) {
                    const currentMap = "<?php echo urlencode($map); ?>";
                    window.location.href = "battle.php?map=" + currentMap;
                } else {
                    alert(result.message);
                }

            } catch (err) {
                console.error(err);
                alert("Failed to save deck.");
            }
        }
    </script>
</body>
</html>