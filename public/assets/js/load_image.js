const inputFile = document.querySelector(".file");
const allInputsImage = document.querySelectorAll(".img");
const imgContainer = document.querySelector(".img-container");
const thisUrl = "http://localhost/final_project/public/";

const imageAndBtn = (img) =>
	`<img src="${thisUrl}assets/img/${img}">
	<span class="del">delete</span>`;
const inputImage = (img) =>
	`<input name="img[]" type="hidden" class="img" value="${img}">`;

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
					imgContainer.innerHTML += `<div class="img-item">
						${inputImage(name)}
					</div>`;
				}
				inputValue();
				deleteClick();
			});
	}
};

const deleteImage = async (container) => {
	var imageSrc = container.querySelector(".img").value;
	let allSrc = 0;
	allInputsImage.forEach((input) => {
		if (input.value == imageSrc) {
			allSrc += 1;
		}
	});
	if (allSrc == 1) {
		var formData = new FormData();
		formData.append("src", imageSrc);
		await fetch(thisUrl + "get/delete-image", {
			method: "POST",
			body: formData,
		});
	}
	container.remove();
};

const inputValue = () => {
	const allImageContainer = document.querySelectorAll(".img-item");
	if (allImageContainer) {
		allImageContainer.forEach((container) => {
			const img = container.querySelector("img");
			const input = container.querySelector(".img");
			if (input.value != "" && !img) {
				container.innerHTML += imageAndBtn(input.value);
			}
		});
	}
};

const deleteClick = () => {
	const buttons = imgContainer.querySelectorAll(".del");
	buttons.forEach((btn) => {
		btn.addEventListener("click", () => {
			deleteImage(btn.parentNode);
		});
	});
};

if (inputFile) {
	inputFile.addEventListener("change", uploadImage);
}

deleteClick();
inputValue();
