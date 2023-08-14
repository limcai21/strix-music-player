$(document).ready(function () {
    var oldEmailValue = document.getElementById("emailValue").innerHTML

    $(document).on("click", "#editEmailBtn", function (e) { 
        const input = "<input type='email' name='userEmail' id='userEmail' value='" + oldEmailValue + "' required=''>";
        const saveBtn = "<button title='Save' id='saveEmailBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M6.75 3h-1A2.75 2.75 0 0 0 3 5.75v12.5A2.75 2.75 0 0 0 5.75 21H6v-6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 15v6h.25A2.75 2.75 0 0 0 21 18.25V8.286a3.25 3.25 0 0 0-.952-2.299l-2.035-2.035A3.25 3.25 0 0 0 15.75 3v4.5a2.25 2.25 0 0 1-2.25 2.25H9A2.25 2.25 0 0 1 6.75 7.5V3Z' fill='#fff'/><path d='M14.25 3v4.5a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75V3h6ZM16.5 21v-6a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0-.75.75v6h9Z' fill='#fff'/></svg></button>";
        const cancelBtn = "<button title='Cancel' id='cancelEmailBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='m4.21 4.387.083-.094a1 1 0 0 1 1.32-.083l.094.083L12 10.585l6.293-6.292a1 1 0 1 1 1.414 1.414L13.415 12l6.292 6.293a1 1 0 0 1 .083 1.32l-.083.094a1 1 0 0 1-1.32.083l-.094-.083L12 13.415l-6.293 6.292a1 1 0 0 1-1.414-1.414L10.585 12 4.293 5.707a1 1 0 0 1-.083-1.32l.083-.094-.083.094Z' fill='#fff'/></svg></button>";
        $("#emailEditSection").html(input + saveBtn + cancelBtn);
    });

    $(document).on("click", "#cancelEmailBtn", function (e) { 
        const emailSpan = "<span class='userInfo' id='emailValue'>" + oldEmailValue + "</span>"
        const editBtn = "<button title='Edit' id='editEmailBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z' fill='#fff'/></svg></button>"
        $("#emailEditSection").html(emailSpan + editBtn);
        $("#userEmailError").css("display", "none")
    });





    function validateEmail(str) {
        return /^\S+@\S+\.\S+$/.test(str);
    }

    $(document).on("click", "#saveEmailBtn", function (e) { 
        const newEmailValue = $('#userEmail').val();
        
        if (oldEmailValue != newEmailValue) {

            if (newEmailValue.length != 0) {
                if (!validateEmail(newEmailValue)) {
                    $("#userEmail").css("border-color", "red");
                    $("#userEmailError").css("display", "block");
                    $("#userEmailError").text("Please enter a valid email address");
                }

                else {
                    $.ajax({
                        url: "./process/update_email.php",
                        type: 'post',
                        data: { userEmail: newEmailValue },
                        dataType: 'JSON',
                        success: function (result) {
                            $status = result[0].status

                            if ($status == "1") {
                                // UPDATED
                                oldEmailValue = newEmailValue
                                const emailSpan = "<span class='userInfo' id='emailValue'>" + newEmailValue + "</span>"
                                const editBtn = "<button title='Edit' id='editEmailBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z' fill='#fff'/></svg></button>"
                                $("#userEmail").css("border-color", "darkgray");
                                $("#userEmailError").css("display", "none");    
                                $("#emailEditSection").html(emailSpan + editBtn);
                            }

                            else {
                                if ($status == "2") {
                                    // STH WENT WRONG
                                    $("#userEmail").css("border-color", "red");
                                    $("#userEmailError").css("display", "block");
                                    $("#userEmailError").text("Something went wrong, try again later");
                                }

                                if ($status == "3") {
                                    // EMAIL EXIST ALR
                                    $("#userEmail").css("border-color", "red");
                                    $("#userEmailError").css("display", "block");
                                    $("#userEmailError").text("Email is already taken");
                                }
                            }
                        }
                    })
                }
            }

            else {
                $("#userEmail").css("border-color", "red");
                $("#userEmailError").css("display", "block");
                $("#userEmailError").text("Please enter your email address");
            }
        }

        else {
            $("#userEmail").css("border-color", "red");
            $("#userEmailError").css("display", "block");
            $("#userEmailError").text("Email same as before. Cancel if you don't wish to update");
        }
    });
});

