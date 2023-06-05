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

if (quantitys) {
    const product_price = document.querySelectorAll('.product_price')
    const total_product = document.querySelectorAll('.total_product')
    const total_cart = document.querySelector('.total_cart')
    const numberInCart = document.querySelector('.number_in_cart')
    quantitys.forEach((quantity, index) => {
        quantity.addEventListener('input', () => {
            if (quantity.value >= 1) {
                total_product[index].innerHTML =
                    parseInt(product_price[index].innerHTML, 10) *
                    quantity.value
                let total = 0
                total_product.forEach((price, n) => {
                    if (n != index) {
                        total += parseInt(price.innerHTML, 10)
                    }
                })
                total_cart.innerHTML =
                    total + parseInt(total_product[index].innerHTML, 10)

                var formData = new FormData(
                    quantity.parentNode.parentNode.parentNode.parentNode
                )
                let totalQuantity = fetch('', {
                    method: 'POST',
                    body: formData,
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.properties > 99) {
                            numberInCart.innerHTML = '99+'
                        } else {
                            numberInCart.innerHTML = data.properties
                        }
                    })
            }
        })
    })
}

const addToCart = document.querySelector('.add_to_cart')

if (addToCart) {
    addToCart.addEventListener('submit', () => {
        const numberInCart = document.querySelector('.number_in_cart')
        let number_in_cart =
            parseInt(numberInCart.innerHTML, 10) +
            parseInt(addToCart.querySelector('#quantity').value, 10)
        if (number_in_cart > 99) {
            numberInCart.innerHTML = '99+'
        } else {
            numberInCart.innerHTML = number_in_cart
        }
    })
}

const menuBurger = document.querySelector('.menu_burger')
const closeMenu = document.querySelector('.close-menu')
const menu = document.querySelector('.menu')

if (menuBurger) {
    menuBurger.addEventListener('click', () => {
        menu.classList.add('active')
    })
    closeMenu.addEventListener('click', () => {
        menu.classList.remove('active')
    })
}

const productsDropdown = document.querySelector('.products_dropdown')
const productsLinks = document.querySelector('.products_links')
const bigLinks = document.querySelectorAll('.big_link')

const mouseHoverDropdown = () => {
    menu.style.width = '800px'
    productsLinks.classList.add('active')
}

const mouseHoverLinkorClose = () => {
    menu.style.width = '400px'
    productsLinks.classList.remove('active')
}

const dropdownClick = () => {
    productsDropdown.classList.toggle('active')
    productsLinks.classList.toggle('active')
}

const dropdownMenu = () => {
    if (productsDropdown) {
        if (window.innerWidth <= 1024) {
            menu.style.width = '100%'
            productsDropdown.removeEventListener(
                'mouseover',
                mouseHoverDropdown
            )
            bigLinks.forEach((link) => {
                link.removeEventListener('mouseover', mouseHoverLinkorClose)
            })
            closeMenu.removeEventListener('mouseover', mouseHoverLinkorClose)
            productsDropdown.addEventListener('click', dropdownClick)
        } else {
            productsDropdown.classList.remove('active')
            productsLinks.classList.remove('active')
            menu.style.width = '400px'
            productsDropdown.removeEventListener('click', dropdownClick)
            productsDropdown.addEventListener('mouseover', mouseHoverDropdown)
            bigLinks.forEach((link) => {
                link.addEventListener('mouseover', mouseHoverLinkorClose)
            })
            closeMenu.addEventListener('mouseover', mouseHoverLinkorClose)
        }
    }
}

window.addEventListener('load', dropdownMenu)
window.addEventListener('resize', dropdownMenu)
