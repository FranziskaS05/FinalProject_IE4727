function checkBooking() {
    var name = document.getElementById("name").value.trim();
    var tickets = parseInt(document.getElementById("tickets").value);
    if (!/^[A-Za-z ]{2,}$/.test(name)) {
        alert("Name must contain letters only.");
        return false;
    }
    if (isNaN(tickets) || tickets < 1 || tickets > 10) {
        alert("Tickets must be between 1 and 10.");
        return false;
    }
    return true;
}

function checkRegister() {
    var pw = document.getElementById("reg_password").value;
    var confirm = document.getElementById("reg_confirm").value;
    if (pw.length < 6) {
        alert("Password must be at least 6 characters.");
        return false;
    }
    if (pw !== confirm) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}

function checkUpdate(form) {
    var t = parseInt(form.tickets.value);
    if (isNaN(t) || t < 1 || t > 10) {
        alert("Tickets must be between 1 and 10.");
        return false;
    }
    return true;
}

function checkReview() {
    if (document.querySelectorAll('input[name^="selected"]:checked').length === 0) {
        alert("Please select at least one booking.");
        return false;
    }
    return true;
}