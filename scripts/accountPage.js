function userInfo(){
    fetch("../php/getUser.php")
    .then(res => res.json())
    .then(data => {
        if(data[0]){
            for(var key in data){
                $('#'+key).append(data[key]);
            }
        }
        else{
            window.location.replace("../views/login.html");
        }
    });
}
function userImage(){
    fetch("../php/getUserImage.php")
    .then(res => res.json())
    .then(data => {
        if(data.imageData){
            // Retrieve the base64-encoded image data
            var imageData = data.imageData;

            // set img src to the image data
            $("#user-icon-large img").attr("src", "data:image/jpeg;base64," + imageData);
        }
        else{
            console.error("No image data found");
        }
    })
    .catch(error => {
        console.error("Error retrieving image:", error);
    });

}

function uploadImage(){
    // Create a popup window
    var popup = window.open("", "Upload Image", "width=400,height=300");

    // Create a form element
    var form = document.createElement("form");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("method", "POST");
    form.setAttribute("action", "../php/uploadImage.php");

    // Create an input element for file selection
    var fileInput = document.createElement("input");
    fileInput.setAttribute("type", "file");
    fileInput.setAttribute("name", "image");

    // Create a submit button
    var submitButton = document.createElement("input");
    submitButton.setAttribute("type", "submit");
    submitButton.setAttribute("value", "Upload");

    // Append the file input and submit button to the form
    form.appendChild(fileInput);
    form.appendChild(submitButton);

    // Append the form to the popup window
    popup.document.body.appendChild(form);
}