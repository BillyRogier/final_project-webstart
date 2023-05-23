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
            const productsContainer = document.querySelectorAll(
                'form > .product-container'
            )
            let new_element = productsContainer[0].cloneNode(true)
            const allInputs = new_element.querySelectorAll('input')
            allInputs.forEach((input) => {
                input.value = '1'
            })
            productsContainer[productsContainer.length - 1].after(new_element)
        })
    })
}

const quantitys = document.querySelectorAll('.quantity')

if(quantitys){
    const product_price = document.querySelectorAll('.product_price')
    const total_product = document.querySelectorAll('.total_product')
    const total_cart = document.querySelector('.total_cart')
    quantitys.forEach((quantity, index) => {
        quantity.addEventListener("input", () => {
            
            total_product[index].innerHTML = parseInt(product_price[index].innerHTML, 10) * quantity.value
            let total = 0
            total_product.forEach((price,n) => {
                if(n != index){
                    total += parseInt(price.innerHTML, 10) 
                }
            });
            total_cart.innerHTML = total + parseInt(total_product[index].innerHTML, 10)

            var formData = new FormData(quantity.parentNode.parentNode.parentNode.parentNode)
            fetch("",{
                method: 'POST',
                body: formData,
            })
        })
    });
}

const addToCart = document.querySelector('.add_to_cart')

if(addToCart){
    addToCart.addEventListener("submit", () => {
        const numberInCart = document.querySelector('.number_in_cart')
        numberInCart.innerHTML = parseInt(numberInCart.innerHTML , 10) + 1
    })
}