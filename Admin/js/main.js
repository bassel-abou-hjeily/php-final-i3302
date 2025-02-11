

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".categories").addEventListener("click", function () {
        const category = document.querySelector(".category");
        const settingHidden = document.querySelector(".setting_hidden");

        if (category) {
            if (category.style.display === "none" || category.style.display === "") {
                category.style.display = "block";
            } else {
                category.style.display = "none";
            }
        }

        if (settingHidden) {
            settingHidden.style.display = "none";
        }
    });

    document.querySelector(".setting .button_setting").addEventListener("click", function () {
        const category = document.querySelector(".category");
        const settingHidden = document.querySelector(".setting_hidden");

        if (category) {
            category.style.display = "none";
        }

        if (settingHidden) {
            if (settingHidden.style.display === "none" || settingHidden.style.display === "") {
                settingHidden.style.display = "block";
            } else {
                settingHidden.style.display = "none";
            }
        }
    });

    document.querySelector(".btn_down").addEventListener("click", function () {
        const btnDown = this;
        const btnUp = document.querySelector(".btn_up");
        const slider = document.querySelector(".slider");
        const leftNav = document.querySelector(".LeftNav");
        const rightNav = document.querySelector(".RightNav");
        const l1 = window.outerWidth;

        if (btnDown) btnDown.style.display = "none";
        if (btnUp) btnUp.style.display = "block";
        if (slider) slider.style.display = "block";
        if (leftNav) leftNav.style.top = "110px";

        console.log(l1);

        if (slider) slider.style.width = `${l1}px`;

        if (l1 > 400 && l1 <= 767 && rightNav) {
            rightNav.style.right = "60%";
        } else if (l1 <= 400 && rightNav) {
            rightNav.style.right = "65%";
        }
    });

    document.querySelector(".btn_up").addEventListener("click", function () {
        const btnUp = this;
        const btnDown = document.querySelector(".btn_down");
        const slider = document.querySelector(".slider");
        const leftNav = document.querySelector(".LeftNav");
        const rightNav = document.querySelector(".RightNav");
        const l1 = window.outerWidth;

        if (btnUp) btnUp.style.display = "none";
        if (btnDown) btnDown.style.display = "block";

        if (slider) {
            slider.style.display = "none";

            if (leftNav) leftNav.style.top = "10px";

            if (l1 > 400 && l1 <= 767 && rightNav) {
                rightNav.style.right = "-14%";
            } else if (l1 <= 400 && rightNav) {
                rightNav.style.right = "-7%";
            }
        }
    });
});

