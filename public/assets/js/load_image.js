const inputFile = document.querySelector(".file");
const allInputsImage = document.querySelectorAll(".img");
const imgContainer = document.querySelector(".img-container");
const thisUrl = "http://localhost/final_project/public/";

const image = (src) => `<img src="${src}">`;
const inputImage = (name) =>
	`<input name="img[]" type="hidden" class="img" value="${name}">`;

const getUrl = async (data) => {
	await fetch("http://localhost/final_project/public/get/image")
		.then((response) => response.text())
		.then((url) => {
			imgContainer.innerHTML += image(url + data);
		});
};

const uploadImage = async () => {
	for (var i = 0; i < inputFile.files.length; i++) {
		var formData = new FormData();
		formData.append("file", inputFile.files[i]);
		await fetch("http://localhost/final_project/public/get/upload-image", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.text())
			.then((name) => {
				if (allInputsImage[0].value == "") {
					allInputsImage[0].value = name;
				} else {
					imgContainer.innerHTML += inputImage(name);
				}
				getUrl(name);
			});
	}
};

const deleteImage = async (container) => {
	container.remove();
	// fetch delete image
	// delete container
	var formData = new FormData();
	formData.append("file", inputFile.files[i]);
	await fetch(thisUrl + "get/upload-image", {
		method: "POST",
		body: formData,
	})
		.then((response) => response.text())
		.then((name) => {
			if (allInputsImage[0].value == "") {
				allInputsImage[0].value = name;
			} else {
				imgContainer.innerHTML += inputImage(name);
			}
			getUrl(name);
		});
};

allInputsImage.forEach((input) => {
	if (input.value != "") {
		const inputContainer = input.parentNode;
		inputContainer.innerHTML += image(
			thisUrl + "assets/img/" + input.value
		);
		inputContainer.innerHTML += '<span class="del">delete</span>';
		const buttton = inputContainer.querySelector(".del");
		buttton.addEventListener("click", () => {
			deleteImage(inputContainer);
		});
	}
});

if (inputFile) {
	inputFile.addEventListener("change", uploadImage);
}

// delete image
// if image not in img-container
// -> send delete
