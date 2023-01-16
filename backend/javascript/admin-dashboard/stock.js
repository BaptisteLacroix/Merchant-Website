let currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form...
    let x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n === 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n === (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
}

function nextPrev(n) {
    // This function will figure out which tab to display
    let x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n === 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    resetColor();
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
        // ... the form gets submitted:
        console.log(document.getElementById("adding-element-stock"));
        document.getElementById("adding-element-stock").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}


function resetColor() {
    let y = document.getElementsByClassName("tab");
    let z = y[currentTab].getElementsByTagName("input");
    for (let i = 0; i < z.length; i++) {
        if (z[i].style.display !== "none") {
            z[i].className = z[i].className.replace("invalid", "");
        } else {
            document.getElementById("file-label").className = document.getElementById("file-label").className.replace("invalid", "");
        }
    }
}

function validateForm() {
    // This function deals with validation of the form fields
    let x, y, z, i, valid = true;
    x = document.getElementsByClassName("tab");
    // get all the input elements in the current tab:
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value === "") {
            // add an "invalid" class to the field:

            // Check if the style contain diplay none
            if (y[i].style.display !== "none") {
                if (y[i].className === "") {
                    y[i].className += "invalid";
                } else if (y[i].className.indexOf("invalid") === -1) {
                    y[i].className += " invalid";
                }
                // and set the current valid status to false
                valid = false;
            } else {
                if (y[i].className === "") {
                    document.getElementById("file-label").className += "invalid";
                } else if (y[i].className.indexOf("invalid") === -1) {
                    document.getElementById("file-label").className += " invalid";
                }
            }
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    let i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
}
