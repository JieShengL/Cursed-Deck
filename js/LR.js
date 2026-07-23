/*Programmer name: Mr Lin Xu Zhi
Program name: LR.js
Description: card preview functionality
First written on: Fri, 12-June-2026
Edited on: Monday, 15-June-2026*/
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cardDetailModal");
    const modalImg = document.getElementById("modalCardImg");
    const modalName = document.getElementById("modalCardName");
    const modalDesc = document.getElementById("modalCardDesc");
    const closeBtn = document.querySelector(".modal-close-btn");
    const cardImages = document.querySelectorAll(".viewable-card-img");

    cardImages.forEach(img => {
        img.addEventListener("click", function () {
            modalImg.src = this.getAttribute("data-img");
            modalName.textContent = this.getAttribute("data-name");
            modalDesc.textContent = this.getAttribute("data-desc");
            
            modal.style.display = "flex"; 
        });
    });

    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});