const formContact = document.querySelector("form");
let send = false;
var propertie = "";
let valid = false;

const getValid = (elt) => {
	eltParent = elt.parentNode;
	error = elt.parentNode.querySelector(".error-message");
	error.innerHTML = "";
	valid = false;
	prop = propertie["properties"];
	console.log(propertie);
	if (prop[elt.name]) {
		if (prop[elt.name]["length"]) {
			if (elt.value.length > prop[elt.name]["length"]) {
				error.innerHTML =
					"<li>Le champs " +
					elt.name +
					" doit contenir maximum " +
					prop[elt.name]["length"] +
					" characters</li>";
			}
		}
		if (prop[elt.name]["type"]) {
			if (prop[elt.name]["type"] == "int") {
				if (!/^-?[0-9]+$/.test(elt.value)) {
					error.innerHTML +=
						"<li>Le champs " +
						elt.name +
						" doit contenir seulement des chiffres </li>";
				}
			} else if (prop[elt.name]["type"] == "float") {
				if (!/^-?[0-9-.]+$/.test(elt.value)) {
					error.innerHTML +=
						"<li>Le champs " +
						elt.name +
						" doit contenir seulement des chiffres </li>";
				}
			}
		}
	}
	if (elt.type == "email") {
		var emailTest =
			/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if (!emailTest.test(elt.value)) {
			error.innerHTML += "<li>Veuillez rentrez un email valide</li>";
		}
	}
	if (error.innerHTML == "" && elt.value != "") {
		eltParent.classList.remove("invalid");
		eltParent.classList.add("active");
		valid = true;
	} else if (elt.value == "") {
		error.innerHTML =
			"<li>Veuillez remplir le champs " + elt.name + "</li>";
		eltParent.classList.remove("active");
		eltParent.classList.add("invalid");
	} else if (error.innerHTML != "") {
		eltParent.classList.remove("active");
		eltParent.classList.add("invalid");
	}
};

const formSend = async (form) => {
	var action = form.action;
	var formData = new FormData(form);

	let apiResponse = await fetch(action, {
		method: "POST",
		body: formData,
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.error_container) {
				document.querySelector(".error-container").innerHTML =
					data.error_container;
			}
			return data;
		});

	propertie = apiResponse;
};

const inputEvent = (elements) => {
	elements.forEach((elt) => {
		elt.addEventListener("input", () => {
			getValid(elt);
		});
		getValid(elt);
	});
};

const formSubmit = (form) => {
	form.addEventListener("submit", function (event) {
		event.preventDefault();
		if (send === false || valid === true) {
			send = true;
			const inputForm = form.querySelectorAll("input");
			const textareaForm = form.querySelectorAll("textarea");
			formSend(this);
			inputEvent(inputForm);
			inputEvent(textareaForm);
		}
	});
};

formSubmit(formContact);
