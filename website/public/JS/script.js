const hamburgerMenu = document.getElementById("hamburger-menu");
const sidebar = document.getElementsByClassName("sidebar")[0];

// hamburger menu trigger
hamburgerMenu.addEventListener("click", function () {
    sidebar.classList.toggle("hide");
    console.log("ok");
});

// dropdown akun
const dropdown = document.getElementById("dropdown-trigger");
const itemDropdown = document.getElementById("item-dropdown1");
const itemDropdown2 = document.getElementById("item-dropdown2");

dropdown.addEventListener("click", function () {
    if (itemDropdown.style.display === "none") {
        itemDropdown.style.display = "block";
        itemDropdown2.style.display = "block";
    } else {
        itemDropdown.style.display = "none";
        itemDropdown2.style.display = "none";
    }
});

// dropdown transaksi
const dropdown2 = document.getElementById("dropdown-trigger2");
const itemDropdownTrans = document.getElementById("item-dropdown-topup");
const itemDropdownTrans2 = document.getElementById("item-dropdown-konvertuang");
const itemDropdownTrans3 = document.getElementById("item-dropdown-payment");
const itemDropdownTrans4 = document.getElementById(
    "item-dropdown-historitrans"
);

dropdown2.addEventListener("click", function () {
    if (itemDropdownTrans.style.display === "none") {
        itemDropdownTrans.style.display = "block";
        itemDropdownTrans2.style.display = "block";
        itemDropdownTrans3.style.display = "block";
        itemDropdownTrans4.style.display = "block";
    } else {
        itemDropdownTrans.style.display = "none";
        itemDropdownTrans2.style.display = "none";
        itemDropdownTrans3.style.display = "none";
        itemDropdownTrans4.style.display = "none";
    }
});

// photo profile
const imgDiv = document.querySelector(".user-img");
const img = document.querySelector("#photo");
const file = document.querySelector("#file");
const uploadbtn = document.querySelector("#uploadbtn");

file.addEventListener("change", function () {
    const chosedfile = this.files[0];
    if (chosedfile) {
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            img.setAttribute("src", reader.result);
        });
        reader.readAsDataURL(chosedfile);
    }
});

// charts

const svgPathParent = document.getElementById("svg-path");
const card = document.getElementById("card");
//test arrays: uncomment the array you would like to use and comment the rest otherwise you will get error
//const dataPath2 = [60, 20, 30, 50, 14, 22, 38, 54, 74, 98, 130, 84, 60, 96, 120, 156, 180, 98, 138, 100, 160, 90, 76, 30, 78, 118, 132, 88, 44];
//const dataPath2 = [180, 60, 90, 150, 42, 66, 114, 162, 222, 294, 390, 252, 180, 288, 360, 468, 540, 294, 414, 300, 480, 270, 228, 90, 234, 354, 396, 264, 132];
const dataPath2 = [
    120, 40, 60, 100, 28, 44, 76, 108, 148, 196, 260, 168, 120, 192, 240, 312,
    360, 196, 276, 200, 320, 180, 152, 60, 156, 236, 264, 176, 88,
];

function dataVisualization(array, frequency, linecount) {
    const svgElment = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "svg"
    );
    const svgPath = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "path"
    );
    const days = array.length;
    const maxVal = Math.max(...array);
    const widthSvg = days * frequency;
    const heightSvg = maxVal + 30;
    const graphLine = maxVal / (linecount - 1);

    svgElment.setAttributeNS(null, "width", widthSvg);
    svgElment.setAttributeNS(null, "height", heightSvg);

    // g tags for grouping other tags
    const gElCircle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "g"
    );
    gElCircle.id = "graph-points";

    const gElLine = document.createElementNS("http://www.w3.org/2000/svg", "g");
    gElLine.id = "graph-lines";

    const gElText = document.createElementNS("http://www.w3.org/2000/svg", "g");
    gElText.id = "graph-texts";

    // base line
    let pathString =
        "M" + widthSvg + " " + heightSvg + " L" + 0 + " " + widthSvg;

    for (let d = 0; d < days; d++) {
        const yValue = heightSvg - dataPath2[d],
            xValue = d * frequency;
        const newString = " L" + xValue + " " + yValue;
        pathString += newString;

        const circleEl = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "circle"
        );

        circleEl.setAttributeNS(null, "cx", xValue);
        circleEl.setAttributeNS(null, "cy", yValue);
        circleEl.setAttributeNS(null, "r", "8");
        circleEl.addEventListener("mouseover", (e) => {
            card.style = `top:${yValue}px; left:${
                xValue - 75
            }px; display: block;`;
            // generate date
            const date_ = new Date(
                Date.now() - (days - d) * (24 * 60 * 60 * 1000)
            )
                .toJSON()
                .split("T")[0];
            card.innerHTML = `Views: ${dataPath2[d]} <br>Date: ${date_}`;
        });
        gElCircle.appendChild(circleEl);
    }

    const ends = heightSvg - dataPath2[days - 1];
    pathString += " L" + widthSvg + " " + ends;
    pathString += " Z";
    svgPath.setAttributeNS(null, "d", pathString);

    // lines and texts
    for (let l = 0; l < linecount; l++) {
        const lineEl = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "line"
        );
        const textEl = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "text"
        );
        const yPosition = heightSvg - l * graphLine;
        lineEl.setAttributeNS(null, "x1", "0");
        lineEl.setAttributeNS(null, "y1", yPosition);
        lineEl.setAttributeNS(null, "x2", widthSvg);
        lineEl.setAttributeNS(null, "y2", yPosition);
        gElLine.appendChild(lineEl);

        const txt = l * graphLine;
        textEl.setAttributeNS(null, "dx", "-20");
        textEl.setAttributeNS(null, "x", widthSvg);
        textEl.setAttributeNS(null, "y", yPosition);
        textEl.textContent = txt;

        gElText.appendChild(textEl);
    }

    svgElment.appendChild(gElCircle);
    svgElment.appendChild(gElLine);
    svgElment.appendChild(gElText);
    svgElment.appendChild(svgPath);

    // base parent or graph container
    svgPathParent.appendChild(svgElment);
}

dataVisualization(dataPath2, 50, 3);
