import { ValidForm } from './module/ValidForm.js'
import { InputImage } from './module/InputImage.js'

const forms = document.querySelectorAll('form')
const errorContainer = document.querySelector('.error-container')

if (forms) {
    forms.forEach((form) => {
        var validForm = new ValidForm(form, errorContainer)
        form.addEventListener('submit', (event) => {
            event.preventDefault()
            validForm.formSubmit()
        })
    })
}

const inputsFile = document.querySelectorAll('.file')

if (inputsFile) {
    inputsFile.forEach((input, index) => {
        const dt = new DataTransfer()
        var inputImage = new InputImage(input, dt, forms[index], errorContainer)
        input.addEventListener('change', () => {
            inputImage.loadImage()
        })
    })
}
