document.addEventListener('DOMContentLoaded', function () {

    let ftp_username = document.getElementById("ftp_username");

    document.querySelectorAll('#domain, #ftp_password').forEach(function (field) {
        field.addEventListener('input', function () {
            if (this.validity.valid) {
                this.style.border = "3px solid green"
            } else {
                this.style.border = "3px solid orange"
            }

            if (field.id === 'ftp_password') {
                let errors = validateFtpPassword(field.value, ftp_username)

                if (errors.length > 0) {
                    this.setCustomValidity(errors[0]);
                    this.reportValidity();
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    });
});

function validateFtpPassword(password, ftp_username) {
    const errors = [];

    if (password === '') {
        errors.push('FTP password is required.');
    }

    if (password.length < 5) {
        errors.push('FTP password must be at least 5 characters long.');
    }

    if (password.length > 255) {
        errors.push('FTP password must not exceed 255 characters.');
    }

    if (/[\s'"]/.test(password)) {
        errors.push('FTP password must not contain quotes or spaces.');
    }

    if (/[^\x00-\x7F]/.test(password)) {
        errors.push('FTP password must not contain national alphabet characters.');
    }

    if (ftp_username.value !== "" && password.includes(ftp_username.value.toLowerCase())) {
        errors.push('Username is not allowed in password.');
    }

    return errors;
}