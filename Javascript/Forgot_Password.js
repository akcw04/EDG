function validate_email() {
    var email = document.getElementById("email").value;
    var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!email.match(email_regex)) {
        document.getElementById("val-email").innerHTML = " * Invalid Email Address";
        return false;
    } else {
        document.getElementById("val-email").innerHTML = "";
        return true;
    }
}
