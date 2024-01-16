"use strict"

const clearErrors = () => {

    const errors = document.getElementsByClassName('err');
    for (let item of errors) {

        item.innerHTML = "";
    }
    const inErr = document.getElementsByClassName('in_err');
    for (let item of inErr) {

        item.classList.remove('border-danger')
    }
}
// this function is helping for get html element 
const get = (selector) => {
    const data = document.querySelector(selector);
    return data;
}
//set error message function
const error = (selector, message) => {
    get(selector).innerHTML = message;
}

//define on submit function for login from validetion
const onsubmitHendler = () => {
    //get all from input 
    clearErrors();
    const email = document.getElementById("email"),
        password = document.getElementById("password");

    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (email.value === '') {
        error("#emailMass", "Please enter your email address");
        email.parentElement.classList.add("border-danger");
        return false;
    } else if (!email.value.match(mailformat)) {
        error("#emailMass", "Invalid email address. Please enter a valid email");
        email.parentElement.classList.add("border-danger");
        return false;
    } else if (password.value === "") {
        error("#passwordMass", "Please enter your email address");
        password.parentElement.classList.add("border-danger");
        return false;
    } else if (password.value.length < 5) {
        error("#passwordMass", "password length is less then 5 creators");
        password.parentElement.classList.add("border-danger");
        return false;
    } else {
        return true;
    }
}

// decided to shipping fill shipping address
let shippingState = false;
// define inable shipping address
function shippingAddress() {

    var shipping = document.getElementById('shipping_address');
    var shippingicon = document.getElementById('shippingicon2');

    if (shipping.style.display === "none") {
        shippingState = true;
        shipping.style.display = "block";
        if (shippingicon) {
            shippingicon.style.transform = "rotate(90deg)";
        }

    } else {
        shippingState = false;
        shipping.style.display = "none";
        if (shippingicon) {
            shippingicon.style.transform = "rotate(0deg)";
        }

    }
}


// chackout from validetion
const onchackoutsubmit = () => {

    clearErrors();
    const fname1 = get("#fname1");
    const lname1 = get("#lname1");
    const email = get("#email");
    const payment_phone = get("#payment_phone");
    const countryName1 = get("#countryName1");
    const stateView = get("#stateView");
    const payment_postcode = get("#payment_postcode");
    const payment_address_1 = get("#payment_address_1");
    const payment_address_2 = get("#payment_address_2");

    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (fname1.value === "") {
        fname1.classList.add("border-danger");
        error("#fnameError", "Please enter your first name");
        return false;
    } else if (fname1.value.length > 30) {
        fname1.classList.add("border-danger");
        error("#fnameError", "Your first name is too long");
        return false;
    } else if (lname1.value === "") {
        lname1.classList.add("border-danger");
        error("#lnameError", "Please enter your last name");
        return false;
    } else if (email.value === "") {
        email.classList.add("border-danger");
        error("#emailError", "Please enter your email address");
        return false;
    } else if (!email.value.match(mailformat)) {

        error("#emailError", "Invalid email address. Please enter a valid email");
        email.classList.add("border-danger");
        return false;
    } else if (payment_phone.value === "") {
        error("#paymentPhoneError", "Please enter your phone number");
        payment_phone.classList.add("border-danger");

        return false;
    } else if (!Number(payment_phone.value)) {

        error("#paymentPhoneError", "Invalid phone number. Please enter a valid numeric value");
        payment_phone.classList.add("border-danger");
        return false;
    } else if (payment_phone.value.length < 3 || payment_phone.value.length > 15) {

        error("#paymentPhoneError", "Invalid phone number. Please enter a valid number");
        payment_phone.classList.add("border-danger");
        return false;
    } else if (countryName1.value === "") {
        countryName1.classList.add("border-danger");
        error("#countryNamePhoneError", "Please enter your country name");
        return false;
    } else if (stateView.value === "") {
        stateView.classList.add("border-danger");
        error("#stateViewPhoneError", "Please enter your state name");
        return false;
    } else if (payment_postcode.value === "") {
        payment_postcode.classList.add("border-danger");
        error("#paymentPostcodeError", "Please enter your post code");
        return false;
    } else if (payment_postcode.value.length > 10) {
        payment_postcode.classList.add("border-danger");
        error("#paymentPostcodeError", "Your post code is too long");
        return false;
    } else if (!Number(payment_postcode.value)) {
        payment_postcode.classList.add("border-danger");
        error("#paymentPostcodeError", "Invalid post code. Please enter a valid numeric value");
        return false;
    } else if (payment_address_1.value === "") {
        payment_address_1.classList.add("border-danger");
        error("#paymentAddressError", "Please enter your address");
        return false;
    } else if (payment_address_2.value === "") {
        payment_address_2.classList.add("border-danger");
        error("#paymentAddress2Error", "Please enter your address");
        return false;
    } else if (shippingState) {

        return shippingAddressValidetion();

    } else {
        return true;
    }
}

// shipping address validetion
const shippingAddressValidetion = () => {

    const shippingFirstname = get("#fname");
    const shipping_lastname = get("#lname");
    const shipping_phone = get("#shipping_phone");
    const shipping_country = get("#shipping_country");
    const sh_stateView = get("#sh_stateView");
    const shipping_postcode = get("#shipping_postcode");
    const shipping_address_1 = get("#shipping_address_1");
    const shipping_address_2 = get("#shipping_address_2");

    if (shippingFirstname.value === "") {

        shippingFirstname.classList.add("border-danger");
        error("#shipping_firstname_mess", "Please enter your first name");
        return false;
    } else if (shippingFirstname.value.length > 12) {
        shippingFirstname.classList.add("border-danger");

        error("#shipping_firstname_mess", "Your first name is too long");
        return false;
    } else if (shipping_lastname.value === "") {
        shipping_lastname.classList.add("border-danger");
        error("#shipping_lastname_mess", "Please enter your last name");
        return false;
    } else if (shipping_phone.value === "") {
        error("#shipping_phone_mess", "Please enter your phone number");
        shipping_phone.classList.add("border-danger");
        return false;
    } else if (!Number(shipping_phone.value)) {

        error("#shipping_phone_mess", "Invalid phone number. Please enter a valid numeric value");
        shipping_phone.classList.add("border-danger");
        return false;
    } else if (shipping_phone.value.length < 3 || payment_phone.value.length > 15) {

        error("#shipping_phone_mess", "Invalid phone number. Please enter a valid number");
        shipping_phone.classList.add("border-danger");
        return false;
    } else if (shipping_country.value === "") {
        shipping_country.classList.add("border-danger");
        error("#shipping_country_mess", "Please enter your country name");
        return false;
    } else if (sh_stateView.value === "") {
        sh_stateView.classList.add("border-danger");
        error("#sh_stateView_mess", "Please enter your state name");
        return false;
    } else if (shipping_postcode.value === "") {
        shipping_postcode.classList.add("border-danger");
        error("#shipping_postcode_mess", "Please enter your post code");
        return false;
    } else if (shipping_postcode.value.length > 10) {
        shipping_postcode.classList.add("border-danger");
        error("#shipping_postcode_mess", "Invalid post code. Please enter a valid code");
        return false;
    } else if (!Number(shipping_postcode.value)) {
        shipping_postcode.classList.add("border-danger");
        error("#shipping_postcode_mess", "Invalid post code. Please enter a valid code");
        return false;
    } else if (shipping_address_1.value === "") {
        shipping_address_1.classList.add("border-danger");
        error("#shipping_address_1_mess", "Please enter your address");
        return false;
    } else if (shipping_address_2.value === "") {
        shipping_address_2.classList.add("border-danger");
        error("#shipping_address_2_mess", "Please enter your address");
        return false;
    } else {
        return true;
    }
}


//for Registration  validetion 
const onRegistration = () => {
    clearErrors();
    const firstname = get("#firstname"),
        lastname = get("#lastname"),
        email = get("#email"),
        phone = get("#phone"),
        password = get("#password"),
        confirmPassword = get("#confirmPassword");

    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (firstname.value === "") {
        firstname.parentElement.classList.add("border-danger");
        error("#firstname_error", "Please enter your first name");
        return false;
    } else if (firstname.value.length > 12) {
        firstname.parentElement.classList.add("border-danger");
        error("#firstname_error", "Your first name is too long");
        return false;
    } else if (lastname.value === "") {
        lastname.parentElement.classList.add("border-danger");
        error("#lastname_error", "Please enter your first name");
        return false;
    } else if (lastname.value.length > 12) {
        lastname.parentElement.classList.add("border-danger");
        error("#lastname_error", "Your last name is too long");
        return false;
    } else if (email.value === "") {
        email.parentElement.classList.add("border-danger");
        error("#email_error", "Please enter your email address");
        return false;
    } else if (!email.value.match(mailformat)) {
        error("#email_error", "Invalid email address. Please enter a valid email");
        email.parentElement.classList.add("border-danger");
        return false;
    } else if (phone.value === "") {
        error("#phone_error", "Please enter your phone number");
        phone.parentElement.classList.add("border-danger");
        return false;
    } else if (!Number(phone.value)) {

        error("#phone_error", "Invalid phone number. Please enter a valid number");
        phone.parentElement.classList.add("border-danger");
        return false;
    } else if (phone.value.length < 10 || phone.value.length > 15) {

        error("#phone_error", "Invalid phone number. Please enter a valid number");
        phone.parentElement.classList.add("border-danger");
        return false;
    } else if (password.value === "") {
        password.parentElement.classList.add("border-danger");
        error("#password_error", "Please enter your password");
        return false;
    } else if (password.value.length < 5) {
        password.parentElement.classList.add("border-danger");
        error("#password_error", "Password must be at least 5 characters long.");
        return false;
    } else if (confirmPassword.value === "") {
        confirmPassword.parentElement.classList.add("border-danger");
        error("#confirmPassword_error", "Please enter your confirm Password");
        return false;
    } else if (confirmPassword.value !== password.value) {

        confirmPassword.parentElement.classList.add("border-danger");
        password.parentElement.classList.add("border-danger");
        error("#confirmPassword_error", "password is not match");
        error("#password_error", "password is not match");
        return false;
    } else {
        return true;
    }
}

// for reset password 
const resetPassword = () => {
    clearErrors();
    const current_password = get("#current_password");
    const password = get("#new_password");
    const confirmPassword = get("#confirm_password");

    if (current_password.value === "") {
        current_password.classList.add("border-danger");
        error("#password_err_mess", "Please enter your password");
        return false;
    } else if (current_password.value.length < 5) {
        current_password.classList.add("border-danger");
        error("#password_err_mess", "Password must be at least 5 characters long.");
        return false;
    } else if (password.value === "") {
        password.classList.add("border-danger");
        error("#new_password_err_mess", "Please enter your password");
        return false;
    } else if (password.value.length < 5) {
        password.classList.add("border-danger");
        error("#new_password_err_mess", "Password must be at least 5 characters long.");
        return false;
    } else if (confirmPassword.value === "") {
        confirmPassword.classList.add("border-danger");
        error("#confirm_password_err_mess", "Please enter your confirm Password");
        return false;
    } else if (confirmPassword.value !== password.value) {
        confirmPassword.classList.add("border-danger");
        password.classList.add("border-danger");
        error("#new_password_err_mess", "password is not match");
        error("#confirm_password_err_mess", "password is not match");
        return false;
    } else {
        return true;
    }
}


// for profile page

const onProfileForm = () => {

    clearErrors();
    const fname1 = get("#fname1");
    const lname1 = get("#lname1");
    const email = get("#email");
    const payment_phone = get("#payment_phone");
    const countryName1 = get("#countryName1");
    const stateView = get("#stateView");
    const payment_postcode = get("#payment_postcode");
    const payment_address_1 = get("#payment_address_1");
    const payment_address_2 = get("#payment_address_2");
    const passReset = typeof get("#passReset").value === "string" && get("#passReset").value === "0" ? true : false;
    
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (fname1.value === "") {
        fname1.classList.add("border-danger");
        error("#fnameError", "Please enter your first name");
        return false;
    } else if (fname1.value.length > 30) {
        fname1.classList.add("border-danger");
        error("#fnameError", "Your first name is too long");
        return false;
    } else if (lname1.value === "") {
        lname1.classList.add("border-danger");
        error("#lnameError", "Please enter your last name");
        return false;
    } else if (email.value === "") {
        email.classList.add("border-danger");
        error("#emailError", "Please enter your email address");
        return false;
    } else if (!email.value.match(mailformat)) {

        error("#emailError", "Invalid email address. Please enter a valid email");
        email.classList.add("border-danger");
        return false;
    } else if (payment_phone.value === "") {
        error("#paymentPhoneError", "Please enter your phone number");
        payment_phone.classList.add("border-danger");

        return false;
    } else if (!Number(payment_phone.value)) {

        error("#paymentPhoneError", "Invalid phone number. Please enter a valid numeric value");
        payment_phone.classList.add("border-danger");
        return false;
    } else if (payment_phone.value.length < 3 || payment_phone.value.length > 15) {

        error("#paymentPhoneError", "Invalid phone number. Please enter a valid number");
        payment_phone.classList.add("border-danger");
        return false;
    } else if (countryName1.value === "") {
        countryName1.classList.add("border-danger");
        error("#countryNamePhoneError", "Please enter your country name");
        return false;
    } else if (stateView.value === "") {
        stateView.classList.add("border-danger");
        error("#stateViewPhoneError", "Please enter your state name");
        return false;
    } else if (payment_postcode.value === "") {
        payment_postcode.classList.add("border-danger");
        error("#paymentPostcodeError", "Please enter your post code");
        return false;
    } else if (payment_postcode.value.length > 10) {
        payment_postcode.classList.add("border-danger");
        error("#paymentPostcodeError", "Your post code is too long");
        return false;
    } else if (!Number(payment_postcode.value)) {
        payment_postcode.classList.add("border-danger");
        error("#paymentPostcodeError", "Invalid post code. Please enter a valid numeric value");
        return false;
    } else if (payment_address_1.value === "") {
        payment_address_1.classList.add("border-danger");
        error("#paymentAddressError", "Please enter your address");
        return false;
    } else if (payment_address_2.value === "") {
        payment_address_2.classList.add("border-danger");
        error("#paymentAddress2Error", "Please enter your address");
        return false;
    } else if (passReset) {
        return resetPassword();
    } else {
        return true;
    }
}

// for contact form validetion 

const contactForm = () => {
    clearErrors();
    const email = get("#email");
    const message = get("#message");
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.value === "") {
        email.classList.add("border-danger");
        error("#emailError", "Please enter your email address");
        return false;
    } else if (!email.value.match(mailformat)) {

        error("#emailError", "Invalid email address. Please enter a valid email");
        email.classList.add("border-danger");
        return false;
    } else if (message.value === "") {
        error("#messageERR", "Please enter your message");
        message.classList.add("border-danger");
        return false;
    } else {
        return true;
    }
}

// for email validtion
const emailValidtion = () => {
    const email = get("#email");
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (email.value === "") {
        email.parentElement.classList.add("border-danger");
        error("#emailError", "Please enter your email address");
        return false;
    } else if (!email.value.match(mailformat)) {
        error("#emailError", "Invalid email address. Please enter a valid email");
        email.parentElement.classList.add("border-danger");
        return false;
    } else {
        return true;
    }
}


// for otp validetion
const otpValidetion = () => {
    const otp = get("#otp");
    if (otp.value === "") {
        otp.parentElement.classList.add("border-danger");
        error("#OtpError", "Please enter your otp code");
        return false;
    }
    return true;
}

// for password recovery 
const passwordRecovery = () => {
    clearErrors()
    const password = get("#password");
    const confirmPassword = get("#confirm_password");

    if (password.value === "") {
        password.parentElement.classList.add("border-danger");
        error("#new_password_err_mess", "Please enter your password");
        return false;
    } else if (password.value.length < 5) {
        password.parentElement.classList.add("border-danger");
        error("#new_password_err_mess", "Password must be at least 5 characters long.");
        return false;
    } else if (confirmPassword.value === "") {
        confirmPassword.parentElement.classList.add("border-danger");
        error("#confirm_password_err_mess", "Please enter your confirm Password");
        return false;
    } else if (confirmPassword.value !== password.value) {
        confirmPassword.parentElement.classList.add("border-danger");
        password.parentElement.classList.add("border-danger");
        error("#new_password_err_mess", "password is not match");
        error("#confirm_password_err_mess", "password is not match");
        return false;
    }
}