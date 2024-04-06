function formvalid() {

    var password_val = document.getElementById("password").value;
    if (password_val.length <= 8 || password_val.length >= 20) {
      document.getElementById("val-password").innerHTML = " * Minimum 8 characters";
      return false;
    } else {
      document.getElementById("val-password").innerHTML = "";
    }
  }
