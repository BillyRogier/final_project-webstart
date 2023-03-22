const formContact = document.querySelector(".form-contact");
const filters = document.querySelectorAll(".filter");

// Verified error email by js
// var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
// return re.test(email);

// Verified error admin by this thing at the bottom

const getValid = (elt) => {
	eltParent = elt.parentNode;
	error = elt.parentNode.querySelector(".error-message");
	if (elt.value != "" && error.innerHTML == "") {
		eltParent.classList.remove("invalid");
		eltParent.classList.add("active");
	} else {
		formSend(formContact);
		eltParent.classList.remove("active");
		eltParent.classList.add("invalid");
	}
};

const formSend = async (form) => {
	var action = form.action;
	var formData = new FormData(form);

	fetch(action, {
		method: "POST",
		body: formData,
	})
		.then((response) => response.json())
		.then((data) => {
			Object.keys(data).forEach(function (elt) {
				input = form.querySelector("#" + elt);
				errorContainer = document.querySelector(".error-container");
				if (!input) {
					errorContainer.innerHTML = "error occured";
				} else {
					inputParent = input.parentNode;
					error = inputParent.querySelector(".error-message");
					error.innerHTML = data[elt];
				}
			});
		});
};

const inputEvent = (elements) => {
	elements.forEach((elt) => {
		elt.addEventListener("input", () => {
			getValid(elt);
			error.innerHTML = "";
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
