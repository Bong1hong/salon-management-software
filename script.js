// functions when user presses next in booking appointment

function onCompleteDateInfo() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');

	const appointmentDate = document.getElementById('appointment-date').value;
	const appointmentTime = document.getElementById('appointment-time').value;

	if (!appointmentDate || appointmentTime == "none") {
		if (!appointmentDate) {
			$('#appointment-date')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}

		if (appointmentTime == "none") {
			$('#appointment-time')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}
	}
	else {
		sessionStorage.setItem("date", appointmentDate);
		sessionStorage.setItem("time", appointmentTime);

		dateForm.style.display = "none";
		serviceForm.style.display = "block";

		dateStep.classList.remove("active");
		dateStep.classList.add("completed");
		serviceStep.classList.add("active");
	}	
}


function onCompleteServicesInfo() {
	// use xhr here
	const serviceForm = document.getElementById('service-form');
	const requestForm = document.getElementById('request-form');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');

  const service = document.getElementById('service').value;
  const hairdresser = document.getElementById('hairdresser').value;

	if (service === "none" || hairdresser == "none") {
		if (service === "none") {
			$('#service')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}

		if (hairdresser == "none") {
			$('#hairdresser')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}
	}
	else {
		sessionStorage.setItem("service", service);
	  sessionStorage.setItem("hairdresser", hairdresser);

		serviceForm.style.display = "none";
		requestForm.style.display = "block";

		serviceStep.classList.remove("active");
		serviceStep.classList.add("completed");
		requestStep.classList.add("active");
	}

}


function onCompleteRequestInfo() {
	const requestForm = document.getElementById('request-form');
	const summaryForm = document.getElementById('summary-form');
	const requestStep = document.getElementById('request-step');
	const summaryStep = document.getElementById('summary-step');

  const request = document.getElementById('request-box').value;

	if (!document.getElementById('request-box').disabled && request == "") {
		$('#request-box')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
	}
	else {
		if (!request) {
			sessionStorage.setItem("request", "none");
		}
		else {
			sessionStorage.setItem("request", request);
		}

	  document.getElementById('summary-date').innerHTML = `Date: ${sessionStorage.getItem("date")}`;
	  document.getElementById('summary-time').innerHTML = `Time: ${sessionStorage.getItem("time")}`;
	  document.getElementById('summary-service').innerHTML = `Service: ${sessionStorage.getItem("service")}`;
	  document.getElementById('summary-hairdresser').innerHTML = `Hairdresser: ${sessionStorage.getItem("hairdresser")}`;
	  document.getElementById('summary-request').innerHTML = `Special Request: ${sessionStorage.getItem("request")}`;

	  requestForm.style.display = "none";
	  summaryForm.style.display = "block";
		
		requestStep.classList.remove("active");
		requestStep.classList.add("completed");
		summaryStep.classList.remove("disabled");
		summaryStep.classList.add("active");
	}
}


function onConfirmSummary() {
	const summaryForm = document.getElementById('summary-form');
	const summaryStep = document.getElementById('summary-step');
	const requestBox = document.getElementById('request-box');

  const date = sessionStorage.getItem("date");
  const time = sessionStorage.getItem("time");
  const service = sessionStorage.getItem("service");
  const hairdresser = sessionStorage.getItem("hairdresser");
  const request = sessionStorage.getItem("request");

	// sanitize content of special request
	if (requestBox.disabled == false && (requestBox.value.includes('<') || requestBox.value.includes('>'))) {
		alert ("Please don't include special characters in your request");
	} else {
    const http = new XMLHttpRequest();
    const url = 'appointment-process.php';
    const params = `date=${date}&time=${time}&service=${service}&hairdresser=${hairdresser}&request=${request}`;
    http.open('POST', url, true);

    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
      if(http.readyState == 4 && http.status == 200) {
      	if (http.responseText.trim() == "success") {
      		$('#success-booking-modal')
            .modal('show');
      	}
      	else {
					$('#fail-booking-modal')
            .modal('show');
      	}
      }
    }
    http.send(params);

		summaryStep.classList.add("completed");
		summaryStep.classList.remove("active");
	}
}


// functions when user presses back to previous in booking appointment

function onBackToDate() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');

	serviceForm.style.display = "none";
	dateForm.style.display = "block";

	dateStep.classList.add("active");
	dateStep.classList.remove("completed");
	serviceStep.classList.remove("active");
}

function onBackToService() {
	const serviceForm = document.getElementById('service-form');
	const requestForm = document.getElementById('request-form');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');

	requestForm.style.display = "none";
	serviceForm.style.display = "block";

	serviceStep.classList.add("active");
	serviceStep.classList.remove("completed");
	requestStep.classList.remove("active");
}


// function when users edit appointment summary

function onEditSummary() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const summaryForm = document.getElementById('summary-form');

	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');
	const summaryStep = document.getElementById('summary-step');

	summaryForm.style.display = "none";
	dateForm.style.display = "block";

	dateStep.classList.remove("completed");
	dateStep.classList.add("active");
	serviceStep.classList.remove("completed");
	requestStep.classList.remove("completed");
	summaryStep.classList.remove("active");
}

function onSwitchRequest() {
	let hasRequest = document.getElementById('hasRequest').checked;
	let requestBox = document.getElementById('request-box');

	requestBox.disabled = hasRequest ? true : false;
}

/***** Sign Up validation *****/
function validateSignUpName() {
    // Should only contain alphabets and space
    let name = document.getElementById("name").value;
    let nameAlert = document.getElementById("signup-name-alert");
    let regex = /^[a-zA-Z ]*$/;
    let result = regex.test(name);
    if (name.length == 0 ) {
        nameAlert.textContent = "Name should not be empty";
        nameAlert.style.color = "red";
        return false;
    } else if (!result ) {
        nameAlert.textContent = "Name should only contains alphabets and spaces";
        nameAlert.style.color = "red";
        return false;
    } else {
        nameAlert.textContent = "";
        return true;
    }
    return true;
}

function validateSignUpEmail() {
    // Should meet the email format
    let email = document.getElementById("email").value;
    let emailAlert = document.getElementById("signup-email-alert");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else {
        emailAlert.textContent = "";
        return true;
    }
    return true;
}

function validateSignUpPassword() {
    // Should between 6 to 12 characters
    let password = document.getElementById("pass").value;
    let passwordAlert = document.getElementById("signup-password-alert");
    if (password.length == 0) {
        passwordAlert.textContent = "Password should not be empty";
        passwordAlert.style.color = "red";
        return false;
    } else if (password.length < 6 || password.length > 12) {
        passwordAlert.  textContent = "Password length should in between 6 to 12 character(s)";
        passwordAlert.style.color = "red";
        return false;
    } else {
        passwordAlert.textContent = "";
        return true;
    }
    return true;
}

function validateSignUpRepeatPassword() {
    // Password and repeat password should be the same
    let repeatPassword = document.getElementById("re-pass").value;
    let password = document.getElementById("pass").value;
    let repeatPassAlert = document.getElementById("signup-retypepassword-alert");
    if (repeatPassword != password) {
        repeatPassAlert.textContent = "Repeat Password are not the same as the password typed above";
        repeatPassAlert.style.color = "red";
        return false;
    } else {
        repeatPassAlert.textContent = "";
        return true;
    }
    return true;
}

function startSignUpValidate() {
    let name = validateSignUpName();
    let email = validateSignUpEmail();
    let password = validateSignUpPassword();
    let repeatPassword = validateSignUpRepeatPassword();

    if (name && email && password && repeatPassword) {
        return true;
    }
    return false;
}

/***** Log In validation *****/
function validateLogInEmail() {
    // Should meet the email format
    let email = document.getElementById("login-email").value;
    let emailAlert = document.getElementById("login-email-alert");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else {
        emailAlert.textContent = "";
        return true;
    }
    return true;
}

function startLogInValidate() {
    let email = validateLogInEmail();

    if (email) {
        return true;
    }
    return false;
}

/***** Forgot Password validation *****/
function forgotPasswordEmailValidation() {
    let email = document.getElementById("forgot-password-email").value;
    let emailAlert = document.getElementById("forgot-password-email-alert");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else {
        emailAlert.textContent = "";
        return true;
    }
    return true;
}

/***** Reset Password validation *****/
function resetPasswordValidation() {
    // Should between 6 to 12 characters
    let password = document.getElementById("reset-password").value;
    let passwordAlert = document.getElementById("reset-password-alert");
    if (password.length == 0) {
        passwordAlert.textContent = "Password should not be empty";
        passwordAlert.style.color = "red";
        return false;
    } else if (password.length < 6 || password.length > 12) {
        passwordAlert.textContent = "Password length should in between 6 to 12 character(s)";
        passwordAlert.style.color = "red";
        return false;
    } else {
        passwordAlert.textContent = "";
        return true;
    }
    return true;
}
function resetRepeatPasswordValidation() {
    let repeatPassword = document.getElementById("reset-repeatpassword").value;
    let password = document.getElementById("reset-password").value;
    let repeatPassAlert = document.getElementById("reset-retypepassword-alert");
    if (repeatPassword != password) {
        repeatPassAlert.textContent = "Repeat Password are not the same as the password typed above";
        repeatPassAlert.style.color = "red";
        return false;
    } else {
        repeatPassAlert.textContent = "";
        return true;
    }
    return true;
}

function startResetPasswordValidate() {
    let pass = resetPasswordValidation();
    let re_pass = resetRepeatPasswordValidation();

    if (pass && re_pass) {
        return true;
    }
    return false;
}

/* Show Hidden Form */
function openForm() {
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

function onViewAppointment(appointmentId, userId, date, time, service, hairdresser, request) {

	if (!$('#appointment-details-modal').modal('is active')) {
		sessionStorage.setItem('appId', appointmentId);

		document.getElementById('appDetails-user').innerHTML = userId;
		document.getElementById('appDetails-date').innerHTML = date;
		document.getElementById('appDetails-time').innerHTML = time;
		document.getElementById('appDetails-service').innerHTML = service;
		document.getElementById('appDetails-hairdresser').innerHTML = hairdresser;
		document.getElementById('appDetails-request').innerHTML = request;

		$('#appointment-details-modal')
	  	.modal('show');
	}
}

function onCloseAppDetail() {
	$('#appointment-details-modal')
  	.modal('hide');
}

function onHoverCloseDetail() {
	$('#close-app-mark')
	  .transition('tada');
}

function onDeleteAppointment() {
	$('#appointment-details-modal')
	  .modal({
	    allowMultiple: false
	  });

	$('.mini.modal')
		.modal({
			onApprove: function() {
				deleteApproved();
			}
		})
  	.modal('show');
}

function deleteApproved() {
	let appId = sessionStorage.getItem('appId');

	const http = new XMLHttpRequest();
  const url = '../appointment-process.php';
  const params = `appId=${appId}&action=delete`;
  http.open('POST', url, true);

  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  http.onreadystatechange = function() {
    if(http.readyState == 4 && http.status == 200) {
    // 	if (http.responseText.trim() == "success") {
    // 		$('#success-booking-modal')
    //       .modal('show');
    // 	}
    // 	else {
				// $('#fail-booking-modal')
    //       .modal('show');
    // 	}
		  setTimeout(function() {
		  	document.location.reload();
		  }, 500);
    }
  }
  http.send(params);
}