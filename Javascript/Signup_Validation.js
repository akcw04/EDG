function formvalid() {
    var password_val = document.getElementById("Password").value;
  
    if (password_val.length <= 7) {
        document.getElementById("val-password").innerHTML = " * Password must be at least 8 characters long";
        return false;
      } else if (!/[!@#$%^&*]/.test(password_val)) {
        document.getElementById("val-password").innerHTML = " * Contain at least one special character";
        return false; 
      }  else {
        document.getElementById("val-password").innerHTML = "";
        return true;
      }
  }

function Validate_Password() {
    var password_val = document.getElementById("Password").value;
    var confirm_password_val = document.getElementById("Confirm_Password").value;

    if (password_val !== confirm_password_val) {
        document.getElementById("val-confirm").innerHTML = " * Passwords do not match";
        return false;
    } else {
        document.getElementById("val-confirm").innerHTML = "";
        return true;
    }
}

function validate_phone_number() {
    var phone_number = document.getElementById("PhoneNumber").value;
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
    var email = document.getElementById("Email").value;
    var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!email.match(email_regex)) {
        document.getElementById("val-email").innerHTML = " * Invalid Email Address";
        return false;
    } else {
        document.getElementById("val-email").innerHTML = "";
        return true;
    }
}
