import { ValidForm } from './module/ValidForm.js'
import { InputImage } from './module/InputImage.js'

const forms = document.querySelectorAll('form')
const errorContainer = document.querySelector('.error-container')
const validForm = (form) => new ValidForm(form, errorContainer)

if (forms) {
    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault()
            validForm(form).formSubmit()
        })
    })
}

const inputsFile = document.querySelectorAll('.file')

if (inputsFile) {
    inputsFile.forEach((input, index) => {
        const dt = new DataTransfer()
        var inputImage = new InputImage(
            input,
            dt,
            forms[index],
            errorContainer,
            validForm(forms[index])
        )
        input.addEventListener('change', () => {
            inputImage.loadImage()
        })
    })
}

const addProducts = document.querySelectorAll('.add_prdt')

if (addProducts) {
    addProducts.forEach((btn) => {
        btn.addEventListener('click', () => {
            const productsContainer = document.querySelector(
                'form > .product-container'
            )
            let new_element = productsContainer.cloneNode(true)
            const allInputs = new_element.querySelectorAll('input')
            allInputs.forEach((input) => {
                input.value = '1'
            })
            productsContainer.after(new_element)
        })
    })
}
