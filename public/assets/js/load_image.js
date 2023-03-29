const inputFile = document.querySelector('.file')
const allInputsImage = document.querySelectorAll('.img')
const imgContainer = document.querySelector('.img-container')
const thisUrl = 'http://localhost/final_project/public/'

const imageAndBtn = (img) =>
    `<img src="${thisUrl}assets/img/${img}">
	<span class="del">delete</span>`
const inputImage = (img) =>
    `<input name="img[]" type="hidden" class="img" value="${img}">`

const uploadImage = async () => {
    for (var i = 0; i < inputFile.files.length; i++) {
        var formData = new FormData()
        formData.append('file', inputFile.files[i])
        await fetch(thisUrl + 'get/upload-image', {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.text())
            .then((name) => {
                if (allInputsImage[0].value == '') {
                    allInputsImage[0].value = name
                } else {
                    imgContainer.innerHTML += `<div class="img-item">
						${inputImage(name)}
					</div>`
                }
            })
        setImageBtnInputs()
        deleteClick()
    }
}

const deleteImage = async (container) => {
    const allInputsImage = document.querySelectorAll('.img')
    const inputContainer = container.querySelector('.img')
    var imageSrc = inputContainer.value
    let allSrc = 0
    allInputsImage.forEach((input) => {
        if (input.value == imageSrc) {
            allSrc += 1
        }
    })
    if (allSrc == 1) {
        var formData = new FormData()
        formData.append('src', imageSrc)
        await fetch(thisUrl + 'get/delete-image', {
            method: 'POST',
            body: formData,
        })
    }
    if (allInputsImage.length <= 1) {
        container.querySelector('img').remove()
        container.querySelector('.del').remove()
        inputContainer.value = ''
    } else {
        container.remove()
    }
}

const deleteClick = () => {
    if (imgContainer) {
        const buttons = imgContainer.querySelectorAll('.del')
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                deleteImage(btn.parentNode)
            })
        })
    }
}

const setImageBtnInputs = () => {
    const allImageContainer = document.querySelectorAll('.img-item')
    if (allImageContainer) {
        allImageContainer.forEach((container) => {
            const img = container.querySelector('img')
            const input = container.querySelector('.img')
            if (input.value != '' && !img) {
                container.innerHTML += imageAndBtn(input.value)
            }
        })
    }
}

if (inputFile) {
    inputFile.addEventListener('change', uploadImage)
}

setImageBtnInputs()
deleteClick()
