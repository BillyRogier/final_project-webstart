class Slider {
    startTouchX = 0
    lastDeltaX = 0
    index = 0
    move = false

    constructor(slider, sliderItems) {
        this.slider = slider
        this.sliderItems = sliderItems
        this.sliderItemWitdh = this.sliderItems[0].offsetWidth + 20
        this.sliderWitdh = this.slider.offsetWidth
        this.addSliderItem(sliderItems)
        this.showItems = Math.ceil(slider.offsetWidth / this.sliderItemWitdh)
    }

    addSliderItem() {
        this.sliderItems.forEach((item, index) => {
            if (index < this.sliderItems.length - 2) {
                this.slider.appendChild(item.cloneNode(true))
            }
        })
        this.slider.insertBefore(
            this.sliderItems[this.sliderItems.length - 1].cloneNode(true),
            this.slider.firstChild
        )
        this.slider.insertBefore(
            this.sliderItems[this.sliderItems.length - 2].cloneNode(true),
            this.slider.firstChild
        )
        this.index = 2
        this.slider.style.transition = '0s'
        this.slider.style.transform = `translate3d(-${
            2 * this.sliderItemWitdh
        }px, 0, 0)`
        this.slider = document.querySelector(`.${this.slider.classList}`)
        this.sliderItems = slider.children
        this.slider.style.transition = ' 0s'
    }

    setPosition = () => {
        this.move = true
        this.slider.style.transition = ' 0.3s'
        this.sliderItemWitdh = this.sliderItems[0].offsetWidth + 20
        this.slider.style.transform = `translate3d(-${
            this.index * this.sliderItemWitdh
        }px, 0, 0)`
        setTimeout(() => {
            this.slider.style.transition = '0s'
            if (
                this.index >= this.sliderItems.length / 2 &&
                this.lastDeltaX > 0
            ) {
                this.index -= this.sliderItems.length / 2
            }
            if (this.index <= 0 && this.lastDeltaX < 0) {
                this.index += this.sliderItems.length / 2
            }
            this.slider.style.transform = `translate3d(-${
                this.index * this.sliderItemWitdh
            }px, 0, 0)`
            this.move = false
        }, 300)
    }

    touchStart = (e) => {
        if (this.move) {
            return
        }
        this.startTouchX = e.touches[0].screenX
        this.sliderWitdh = this.slider.offsetWidth
        this.slider.style.transition = '0s'
    }

    touchMove = (e) => {
        if (this.move) {
            return
        }

        const deltaX = e.touches[0].screenX - this.startTouchX
        this.lastDeltaX = deltaX
        const basePercentTranslate = -this.index * this.sliderItemWitdh
        const percentTranslate =
            basePercentTranslate + (100 * deltaX * 2) / this.sliderWitdh
        this.slider.style.transform = `translate3d(${percentTranslate}px, 0, 0)`
    }

    touchEnd = () => {
        if (this.move) {
            return
        }
        if (Math.abs(this.lastDeltaX / this.sliderWitdh) > 0.1) {
            if (this.index !== 0 && this.lastDeltaX > 0) {
                this.index--
                this.lastDeltaX = -100
            } else {
                this.index++
                this.lastDeltaX = 100
            }
        }
        this.setPosition()
    }

    goToNext = () => {
        if (this.move) {
            return
        }
        this.index++
        this.lastDeltaX = 100
        this.setPosition()
    }

    goToPrev = () => {
        if (this.move) {
            return
        }
        this.index--
        this.lastDeltaX = -100
        this.setPosition()
    }
}

const sliderContainer = document.querySelector('.slider-container')
const slider = sliderContainer.querySelector('.slider')
const nextBtn = document.querySelector('.arrow.next')
const prevBtn = document.querySelector('.arrow.prev')

const classSlider = new Slider(slider, slider.querySelectorAll('.slider-item'))

sliderContainer.addEventListener('touchstart', (e) => {
    classSlider.touchStart(e)
})

sliderContainer.addEventListener('touchmove', (e) => {
    classSlider.touchMove(e)
})

sliderContainer.addEventListener('touchend', () => {
    classSlider.touchEnd()
})

nextBtn.addEventListener('click', () => {
    classSlider.goToNext()
})

prevBtn.addEventListener('click', () => {
    classSlider.goToPrev()
})

window.addEventListener('resize', () => {
    classSlider.setPosition()
})
