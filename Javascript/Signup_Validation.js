function formvalid() {

    var password_val = document.getElementById("password").value;

    if (password_val.length <= 8 || password_val.length >= 20) {
      document.getElementById("val-password").innerHTML = " * Minimum 8 characters";
      return false;
    } else {
      document.getElementById("val-password").innerHTML = "";
      return true;
    }
  }

// Get the password and confirm password fields
const passwordField = document.getElementById('password');
const confirmPasswordField = document.getElementById('confirmPassword');

// Function to validate the password
function Validate_Password() {

    var password_val = document.getElementById("password").value;
    var confirm_password_val = document.getElementById("confirm_password").value;

    if (password_val !== confirm_password_val) {
        // Passwords do not match
        document.getElementById("val-confirm").innerHTML = " * Passwords do not Match";
        return false;
    } else {
        // Passwords match
        document.getElementById("val-confirm").innerHTML = "";
        return true;
    }
}

// Add event listeners to the password and confirm password fields
passwordField.addEventListener('input', validatePassword);
confirmPasswordField.addEventListener('input', validatePassword);

function validate_phone_number() {
    var phone_number = document.getElementById("phone").value;
    var phone_number_regex = /^[0-9]{10}$/;
    if (!phone_number.match(phone_number_regex)) {
        document.getElementById("val-phone").innerHTML = " * Invalid Phone Number";
        return false;
    } else {
        document.getElementById("val-phone").innerHTML = "";
        return true;
    }
}

function validate_email() {
    var email = document.getElementById("email").value;
    var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!email.match(email_regex)) {
        document.getElementById("val-email").innerHTML = " * Invalid Email";
        return false;
    } else {
        document.getElementById("val-email").innerHTML = "";
        return true;
    }
}