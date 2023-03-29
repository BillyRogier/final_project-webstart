const forms = document.querySelectorAll('form')
let send = false
let valid = false

const successRedirection = (data) => {
    if (data.success_location) {
        window.location.href = data.success_location
    }
    return false
}

const getValid = (elt, propertie) => {
    const eltParent = /[\[\]\\?]/g.test(elt.name)
        ? elt.parentNode.parentNode
        : elt.parentNode
    const error = eltParent.querySelector('.error-message')
    error.innerHTML = ''
    valid = false
    const prop = propertie['properties']
    const eltName = elt.name.replace('[]', '')
    if (prop[elt.name]) {
        if (prop[elt.name]['length']) {
            if (elt.value.length > prop[elt.name]['length']) {
                error.innerHTML =
                    '<li>Le champs ' +
                    elt.name +
                    ' doit contenir maximum ' +
                    prop[elt.name]['length'] +
                    ' characters</li>'
            }
        }
        if (prop[elt.name]['type']) {
            if (prop[elt.name]['type'] == 'int') {
                if (!/^-?[0-9]+$/.test(elt.value)) {
                    error.innerHTML +=
                        '<li>Le champs ' +
                        elt.name +
                        ' doit contenir seulement des chiffres </li>'
                }
            } else if (prop[elt.name]['type'] == 'float') {
                if (!/^-?[0-9-.]+$/.test(elt.value)) {
                    error.innerHTML +=
                        '<li>Le champs ' +
                        elt.name +
                        ' doit contenir seulement des chiffres </li>'
                }
            }
        }
    }
    if (elt.type == 'email') {
        var emailTest =
            /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
        if (!emailTest.test(elt.value)) {
            error.innerHTML += '<li>Veuillez rentrez un email valide</li>'
        }
    }
    if (error.innerHTML == '' && elt.value != '' && elt.type != 'file') {
        eltParent.classList.remove('invalid')
        eltParent.classList.add('active')
        valid = true
    } else if (elt.value == '' && elt.type != 'file') {
        error.innerHTML = '<li>Veuillez remplir le champs ' + eltName + '</li>'
        eltParent.classList.remove('active')
        eltParent.classList.add('invalid')
    } else if (error.innerHTML != '') {
        eltParent.classList.remove('active')
        eltParent.classList.add('invalid')
    }
}

async function formSend(form) {
    var action = form.action
    var formData = new FormData(form)

    const response = await fetch(action, {
        method: 'POST',
        body: formData,
    })
    if (response.ok === true) {
        return response.json()
    }
}

const inputEvent = (elements, prop) => {
    elements.forEach((elt) => {
        elt.addEventListener('input', () => {
            getValid(elt, prop)
        })
        elt.addEventListener('change', () => {
            getValid(elt, prop)
        })
        getValid(elt, prop)
    })
}

const formSubmit = (form) => {
    form.addEventListener('submit', function (event) {
        event.preventDefault()
        if (send === false || valid === true) {
            const inputForm = form.querySelectorAll('input')
            const textareaForm = form.querySelectorAll('textarea')
            send = true
            formSend(this).then((data) => {
                if (!successRedirection(data)) {
                    inputEvent(inputForm, data)
                    inputEvent(textareaForm, data)
                    document.querySelector('.error-container').innerHTML =
                        data.error_container
                }
            })
        }
    })
}

if (forms) {
    forms.forEach((form) => {
        formSubmit(form)
    })
}
