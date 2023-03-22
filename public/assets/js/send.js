const filters = document.querySelectorAll(".filter");

filters.forEach((filter) => {
	filter.addEventListener("click", () => {
		filters.forEach((filterActive) => {
			filterActive.classList.remove("active");
		});
		filter.classList.add("active");
		fetch(filter.getAttribute("data-link"))
			.then((response) => response.text())
			.then((data) => {
				const sliderContainer = document.querySelector(
					"#project > .data > .slider-container"
				);
				sliderContainer.innerHTML = "";
				sliderContainer.innerHTML = data;
				const slider = sliderContainer.querySelector(".slider");
				sliderCreation(slider);
			});
	});
});

const formContact = document.querySelector(".form-contact");

const getValid = (elt) => {
	eltParent = elt.parentNode;
	error = elt.parentNode.querySelector(".error-message");
	error.innerHTML = "";
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
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			errorContainer = document.querySelector(".error-container");
			errorContainer.innerHTML = "";
			Object.keys(data).forEach(function (elt) {
				input = form.querySelector("#" + elt);
				if (!input) {
					errorContainer.innerHTML = "error occured";
				}
				if (elt == "error") {
					errorContainer.innerHTML = data[elt];
				}
			});
			return data;
		});

	return apiResponse;
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
		const inputForm = form.querySelectorAll("input");
		const textareaForm = form.querySelectorAll("textarea");
		formSend(this);
		inputEvent(inputForm);
		inputEvent(textareaForm);
	});
};

formSubmit(formContact);
