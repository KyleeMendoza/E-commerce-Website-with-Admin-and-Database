//functions for not logged in users
function showLoginForm_notLoggedIn() {
    // let loginForm = document.getElementById("loginDiv");
    // if (window.getComputedStyle(loginForm, null).getPropertyValue("display") === 'none'){ //correct way to manipulate external css styles
    //     loginForm.style.display="block";
    // } else {
    //     loginForm.style.display="none";
    // }
    location.href = "loginPage.php";

}
function goToCart_notLoggedIn() {
    location.href = "loginPage.php"; //if di pa sila logged in, prompt to login first
}


//functions for logged in users
// function showLoginForm_LoggedIn() {

//     location.href = "userDashboardPage.html";

// }
function goToCart_LoggedIn() {
    location.href = "checkoutpage.php"; //if di pa sila logged in, prompt to login first
}
    












//Determine which page should load up depending on type of customer seelcted, para sa Submit Button  ng Form
function changeForm() { 

    //PWEDE GANTONG WAY
    // if (document.querySelector('input[name="radio"]:checked').value == "Retail"){
    //     document.getElementById('orderForm').action = "retailProducts.html";
    // } else {
    //     document.getElementById('orderForm').action = "supplierProducts.html";
    // }

    //PWEDE DIN TO MAS SIMPLE
    if(document.getElementById('supplier').checked) {
        document.getElementById('orderForm').action = "supplierProducts.php";
    }else {
        document.getElementById('orderForm').action = "retailProducts.php";
    }
}





function deleteItem(id) {
    location.href = "checkoutpage.php?action=delete&id=" + id;
}
//get today's date
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

document.getElementById('OrderDate').value = new Date().toDateInputValue();
document.getElementById('OrderDateModal').value = new Date().toDateInputValue();


// if (document.getElementById('status').value == "Pending"){
//     document.getElementById('status').style.color == "yellow";
// } else {
//     document.getElementById('status').style.color == "green";
// }
