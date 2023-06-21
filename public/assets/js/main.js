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

const quantitys = document.querySelectorAll('.quantity')
const lessQuantity = document.querySelectorAll('.less')
const moreQuantity = document.querySelectorAll('.more')

const changeValueCart = async (quantity, index) => {
    if (quantity.value < 100 && quantity.value > 0) {
        const product_price = document.querySelectorAll('.product_price')
        const total_product = document.querySelectorAll('.total_product')
        const total_cart = document.querySelector('.total_cart')
        const numberInCart = document.querySelector('.number_in_cart')
        if (quantity.value >= 1) {
            var form = quantity.parentNode.parentNode.parentNode.parentNode
            if (!form.classList.contains('add_to_cart')) {
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

                var formData = new FormData(form)
                fetch('', {
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
        }
    }
}

const maxMin = (quantity) => {
    if (quantity.value > 99) {
        quantity.value = 99
    } else if (quantity.value <= 0) {
        quantity.value = 1
    }
}

if (quantitys) {
    quantitys.forEach((quantity, index) => {
        lessQuantity[index].addEventListener('click', () => {
            quantity.value = parseInt(quantity.value, 10) - 1
            maxMin(quantity)
            changeValueCart(quantity, index)
        })
        moreQuantity[index].addEventListener('click', () => {
            quantity.value = parseInt(quantity.value, 10) + 1
            maxMin(quantity)
            changeValueCart(quantity, index)
        })
        quantity.addEventListener('input', () => {
            maxMin(quantity)
            changeValueCart(quantity, index)
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

const dropdownClick = (dropdown, elt) => {
    dropdown.classList.toggle('active')
    elt.classList.toggle('active')
}

const dropdownMenu = () => {
    if (productsDropdown) {
        if (window.innerWidth < 1024) {
            menu.style.width = '100%'
            productsDropdown.removeEventListener(
                'mouseover',
                mouseHoverDropdown
            )
            bigLinks.forEach((link) => {
                link.removeEventListener('mouseover', mouseHoverLinkorClose)
            })
            closeMenu.removeEventListener('mouseover', mouseHoverLinkorClose)
            productsDropdown.addEventListener('click', () => {
                dropdownClick(productsDropdown, productsLinks)
            })
        } else {
            menu.style.width = '400px'
            productsDropdown.classList.remove('active')
            productsLinks.classList.remove('active')
            productsDropdown.removeEventListener('click', () => {
                dropdownClick(productsDropdown, productsLinks)
            })
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

const reviewDropdown = document.querySelector('.drop_review')
const reviewContent = document.querySelector('.reviews-container')
const reviewWrapper = document.querySelector('.review-wrapper')

if (reviewDropdown) {
    reviewDropdown.addEventListener('click', () => {
        dropdownClick(reviewDropdown, reviewContent)
        reviewWrapper.classList.toggle('active')
    })
}

const addGrade = document.querySelectorAll('.add_grade > .grade_ball')
const gradeInput = document.querySelector('#grade')

if (addGrade) {
    addGrade.forEach((ball, index) => {
        ball.addEventListener('click', () => {
            ball.parentNode.parentNode.parentNode.parentNode.querySelector(
                '.error-message'
            ).innerHTML = ''
            addGrade.forEach((ball) => {
                ball.classList.remove('active')
            })
            for (let i = 0; i <= index; i++) {
                addGrade[i].classList.add('active')
            }
            gradeInput.value = index + 1
        })
    })
}

const delPrdtFunction = () => {
    const delPrdt = document.querySelectorAll('.del_prdt')
    if (delPrdt) {
        delPrdt.forEach((btn) => {
            btn.addEventListener('click', () => {
                btn.parentNode.remove()
                delPrdtFunction()
            })
        })
    }
}

const addProducts = document.querySelectorAll('.add_prdt')

if (addProducts) {
    const productsContainer = document.querySelectorAll(
        'form > .product-container'
    )

    productsContainer.forEach((container, index) => {
        if (index >= 1) {
            const delBtn = document.createElement('span')
            delBtn.innerHTML = 'delete product'
            delBtn.classList.add('del_prdt')
            delBtn.classList.add('btn')
            delBtn.classList.add('del')
            container.appendChild(delBtn)
        }
    })

    addProducts.forEach((btn) => {
        btn.addEventListener('click', () => {
            const delBtn = document.createElement('span')
            delBtn.innerHTML = 'delete product'
            delBtn.classList.add('del_prdt')
            delBtn.classList.add('btn')
            delBtn.classList.add('del')
            let new_element = productsContainer[0].cloneNode(true)
            new_element.appendChild(delBtn)
            const allInputs = new_element.querySelectorAll('input')
            allInputs.forEach((input) => {
                input.value = '1'
            })
            productsContainer[productsContainer.length - 1].after(new_element)
            delPrdtFunction()
        })
    })
    delPrdtFunction()
}

var sortableList = document.querySelector('.img-container > .item-container')
if (sortableList) {
    new Sortable(sortableList, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        handle: 'div',
    })
}
