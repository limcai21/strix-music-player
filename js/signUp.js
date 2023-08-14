$(document).ready(function () {
    document.getElementById("signUpForm").addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
    
    
    
    
    
    
    function validateForm() {
        var formOK = true;
    
        var userUsernameVal = document.getElementById("userUsername").value;
        var userContactNoVal = document.getElementById("userContactNo").value;
        var userEmailVal = document.getElementById("userEmail").value;
        var userPasswordVal = document.getElementById("userPassword").value;
        var userPasswordRetypeVal = document.getElementById("userPasswordRetype").value;
    
        var userUsernameError = document.getElementById("userUsernameError");
        var userContactNoError = document.getElementById("userContactNoError");
        var userEmailError = document.getElementById("userEmailError");
        var userPasswordError = document.getElementById("userPasswordError");
        var userPasswordRetypeError = document.getElementById("userPasswordRetypeError");


        // CLEAR BORDER BOTTOM FOR INPUT FIELD
        document.getElementById("userUsername").style.borderColor = "darkgrey";
        document.getElementById("userContactNo").style.borderColor = "darkgrey";
        document.getElementById("userEmail").style.borderColor = "darkgrey";
        document.getElementById("userPassword").style.borderColor = "darkgrey";
        document.getElementById("userPasswordRetype").style.borderColor = "darkgrey";

    
    
        // clear and hide any error messages before we validate [again] (could be a re-validation attempt)
        clearErrorMsgs();
    
    
        // VALIDATION FOR USERNAME
        if (userUsernameVal.length == 0) {
            formOK = false;
            document.getElementById("userUsername").style.borderColor = "red";
            showError(userUsernameError, "Please enter a username");
        }
    
        else if (!validateName(userUsernameVal)) {
            formOK = false;
            document.getElementById("userUsername").style.borderColor = "red";
            showError(userUsernameError, "Username must contain only alphabets");
        }
    
    
        // VALIDATION FOR CONTACT NO
        if (userContactNoVal.length == 0) {
            formOK = false;
            document.getElementById("userContactNo").style.borderColor = "red";
            showError(userContactNoError, "Please enter your contact number");
        }
    
        else if (userContactNoVal.length > 0) {
            if (userContactNoVal.length == 8) {
                if (!validateMobile(userContactNoVal)) {
                    formOK = false;
                    document.getElementById("userContactNo").style.borderColor = "red";
                    showError(userContactNoError, "Contact number must be a Singapore Number");
                }
            }
    
            else {
                formOK = false;
                document.getElementById("userContactNo").style.borderColor = "red";
                showError(userContactNoError, "Contact number must be 8 digits");
            }
        }
    
    
    
        // VALIDATION FOR EMAIL
        if (userEmailVal.length == 0) {
            formOK = false;
            document.getElementById("userEmail").style.borderColor = "red";
            showError(document.getElementById("userEmailError"), "Please enter your email address");
        }
    
        else if (!validateEmail(userEmailVal)) {
            formOK = false;
            document.getElementById("userEmail").style.borderColor = "red";
            showError(document.getElementById("userEmailError"), "Please enter a valid email address");
        }
    
    
    
    
        // VALIDATION FOR PASSWORD
        if (userPasswordVal.length == 0) {
            formOK = false;
            document.getElementById("userPassword").style.borderColor = "red";
            showError(document.getElementById("userPasswordError"), "Please enter a password");
        }

        else {
            if (userPasswordVal.length < 8 || userPasswordVal.length > 16) {
                formOK = false;
                document.getElementById("userPassword").style.borderColor = "red";
                showError(document.getElementById("userPasswordError"), "Password needs to be at least 8 - 16 characters");
            }
        }



        // VALIDATION FOR RETYPE PASSWORD
        if (userPasswordRetypeVal.length == 0) {
            formOK = false;
            document.getElementById("userPasswordRetype").style.borderColor = "red";
            showError(document.getElementById("userPasswordRetypeError"), "Please retype your password");
        }

        else {
            if (userPasswordVal.length < 8 || userPasswordVal.length > 16) {
                formOK = false;
                document.getElementById("userPasswordRetype").style.borderColor = "red";
                showError(document.getElementById("userPasswordRetypeError"), "Password needs to be at least 8 - 16 characters");
            }

            else if (userPasswordRetypeVal != userPasswordVal) {
                formOK = false;
                document.getElementById("userPasswordRetype").style.borderColor = "red";
                document.getElementById("userPassword").style.borderColor = "red";
                showError(document.getElementById("userPasswordRetypeError"), "Password are not the same");
                showError(document.getElementById("userPasswordError"), "Password are not the same");
            }
        }
    
    
        return formOK;
    }
    
    
    
    
    /* VALIDATION REGEX */
    function validateName(str) {
        let pattern = /^[a-zA-Z\s]+$/;
        return pattern.test(str);
    }
    
    function validateMobile(str) {
        return /^(6|8|9)\d{7}$/.test(str);
    }
    
    function validateEmail(str) {
        return /^\S+@\S+\.\S+$/.test(str);
    }
    
    
    
    
    // CLEAR ERROR MESSAGE
    function clearErrorMsgs() {
        document.getElementById("userUsernameError").innerHTML = "";
        document.getElementById("userUsernameError").style.display = "none";
        document.getElementById("userContactNoError").innerHTML = "";
        document.getElementById("userContactNoError").style.display = "none";
        document.getElementById("userEmailError").innerHTML = "";
        document.getElementById("userEmailError").style.display = "none";
        document.getElementById("userPasswordError").innerHTML = "";
        document.getElementById("userPasswordError").style.display = "none";
        document.getElementById("userPasswordRetypeError").innerHTML = "";
        document.getElementById("userPasswordRetypeError").style.display = "none";
    }
    
    
    
    // SHOW ERROR MESSAGE
    function showError(element, msg) {
        element.style.display = "block"; 
        element.innerHTML = msg; 
    }
});