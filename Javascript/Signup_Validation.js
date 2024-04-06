function formvalid() {

    var password_val = document.getElementById("password").value;

    if (password_val.length <= 8 || password_val.length >= 20) {
      document.getElementById("val-password").innerHTML = " * Minimum 8 characters";
      return false;
    } else {
      document.getElementById("val-password").innerHTML = "";
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
    }
}

// Add event listeners to the password and confirm password fields
passwordField.addEventListener('input', validatePassword);
confirmPasswordField.addEventListener('input', validatePassword);