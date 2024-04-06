function trackButtonClick(buttonType) {
    // Send an asynchronous request to the server to track the button click
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "cookie.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("buttonType=" + encodeURIComponent(buttonType));
}