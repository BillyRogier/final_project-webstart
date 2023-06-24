export class Slider {
    startTouchX = 0
    lastDeltaX = 0
    index = 0
    move = false

    constructor(container, slider, sliderItems, sliderIndicators) {
        this.slider = slider
        this.sliderItems = sliderItems
        if (sliderIndicators) {
            this.sliderIndicators = container.querySelectorAll('.indicator')
            this.setActionIndicators()
        }
        this.sliderItemWitdh = this.sliderItems[0].offsetWidth + 20
        this.sliderWitdh = this.slider.offsetWidth
        this.addSliderItem(sliderItems)
        this.showItems = Math.ceil(slider.offsetWidth / this.sliderItemWitdh)
        this.setIndicators()
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
        if (this.sliderItems[this.sliderItems.length - 2]) {
            this.slider.insertBefore(
                this.sliderItems[this.sliderItems.length - 2].cloneNode(true),
                this.slider.firstChild
            )
        }
        this.index = 2
        this.slider.style.transition = '0s'
        this.slider.style.transform = `translate3d(-${
            2 * this.sliderItemWitdh
        }px, 0, 0)`
        this.sliderItems = this.slider.children
        this.slider.style.transition = ' 0s'
    }

    setActionIndicators = () => {
        this.sliderIndicators.forEach((indicator, n) => {
            indicator.addEventListener('click', () => {
                this.index = n + 2
                this.setPosition()
            })
        })
    }

    setPosition = () => {
        this.move = true
        this.slider.style.transition = ' 0.3s'
        this.sliderItemWitdh = this.sliderItems[0].offsetWidth + 20
        this.slider.style.transform = `translate3d(-${
            this.index * this.sliderItemWitdh
        }px, 0, 0)`
        this.setIndicators()
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

    setIndicators() {
        if (this.sliderIndicators) {
            this.sliderIndicators.forEach((indicator) => {
                indicator.classList.remove('active')
            })
            if (this.index == -1 && this.sliderIndicators.length == 2) {
                this.sliderIndicators[
                    this.sliderIndicators.length - 1
                ].classList.add('active')
            } else if (this.index <= 1) {
                this.sliderIndicators[
                    this.sliderIndicators.length + (this.index - 2)
                ].classList.add('active')
            } else if (
                this.index >= 2 &&
                this.index <= this.sliderIndicators.length
            ) {
                this.sliderIndicators[this.index - 2].classList.add('active')
            } else {
                this.sliderIndicators[
                    this.index - this.sliderIndicators.length
                ].classList.add('active')
            }
        }
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
