function InterestUpdate() {
    const rateElement = document.getElementById("interest_rate");
    const durationInput = document.getElementById("duration");
    rateElement.textContent = "";

    durationInput.addEventListener("change", function () {
        let durationInputVal = durationInput.selectedOptions[0].value;
        switch (durationInputVal) {
            case "option0":
                rateElement.textContent = "";
                break;
            case "option1":
                rateElement.textContent = "1%";
                break;
            case "option2":
                rateElement.textContent = "2%";
                break;
            case "option3":
                rateElement.textContent = "3%";
                break;
            case "option4":
                rateElement.textContent = "5%";
                break;
            case "option5":
                rateElement.textContent = "7.5%";
                break;
            case "option6":
                rateElement.textContent = "10%";
                break;
        }
    });
}

function generateWord() {
    let word = '';
    let str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' +
        'abcdefghijklmnopqrstuvwxyz0123456789@#$';

    for (let i = 1; i <= 5; i++) {
        let char = Math.floor(Math.random() * str.length);

        word += str.charAt(char)
    }
    return word;
}

function deleteVerify() {
    const random = generateWord();
    const answer = prompt(`Please enter: ${random} to confirm.`);
    if (answer != random)
        window.location.replace("Profile.php");
}