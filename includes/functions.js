function validateForm(){
    var name= document.getElementById("name");
    var email= document.getElementById("email");
    var date= document.getElementById("date");
    

    let isValid= true;
    if(name.value===""|| ! /^[A-Za-z]+\s+[A-Za-z]+$/.test(name.value)){
        alert("Please fill out the name field in correct format of first name and last name.");
        isValid= false;
    }
    if (email.value===""||!/^[\w.-]+@([\w-]+\.)+[A-Za-z]{2,3}$/.test(email.value)){
        alert("Please fill out the email field in correct format.");
        isValid= false;
    }
    
    if (date.value===""||new Date(date.value) < new Date()){
        alert("Please fill out the date field with a date in the future.");
        isValid= false;
    }
    if(isValid){
        alert("Sumitted successfully!");
        return true;
    }else{
        return false;
    }
}

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