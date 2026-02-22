document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('#domain, #ftp_password').forEach(function (field) {
        field.addEventListener('input', function () {
            if (this.validity.valid) {
                this.style.border = "3px solid green"
            } else {
                this.style.border = "3px solid orange"
            }
        });
    });


});