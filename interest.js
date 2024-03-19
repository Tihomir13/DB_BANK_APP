function InterestUpdate() {
    const rateElement = document.getElementById("interest_rate");
    const durationInput = document.getElementById("duration");
    rateElement.textContent = "1%";

    durationInput.addEventListener("change", function () {
        let durationInputVal = durationInput.selectedOptions[0].value;
        switch (durationInputVal) {
            case "option1":
                rateElement.textContent = "1%";
                break;
            case "option2":
                rateElement.textContent = "1.5%";
                break;
            case "option3":
                rateElement.textContent = "3%";
                break;
            case "option4":
                rateElement.textContent = "5%";
                break;
            default:
                return;
                break;
        }
    });
}
InterestUpdate();
