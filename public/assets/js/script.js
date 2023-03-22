const menuBurger = document.querySelector(".menu-burger");
const menu = document.querySelector(".menu");
const header = document.querySelector("header");
const scrollDown = document.querySelector(".scroll-down");
const filterBar = document.querySelector(".filter_bar");
const scrollFilterRight = document.querySelector(".scroll-filter.right");
const scrollFilterLeft = document.querySelector(".scroll-filter.left");

menuBurger.addEventListener("click", () => {
	menu.classList.toggle("active");
	menuBurger.classList.toggle("active");
});

window.addEventListener("scroll", () => {
	if (window.scrollY >= 20) {
		header.classList.add("active");
	} else {
		header.classList.remove("active");
	}
});

scrollDown.addEventListener("click", () => {
	window.scrollTo(0, window.innerHeight * 0.9);
});

const filterBarScroll = () => {
	if (filterBar.scrollWidth > filterBar.offsetWidth) {
		if (
			filterBar.scrollLeft >=
			filterBar.scrollWidth - filterBar.offsetWidth - 5
		) {
			scrollFilterLeft.style.display = "grid";
			scrollFilterRight.style.display = "none";
		} else if (filterBar.scrollLeft <= 5) {
			scrollFilterLeft.style.display = "none";
			scrollFilterRight.style.display = "grid";
		} else {
			scrollFilterLeft.style.display = "grid";
			scrollFilterRight.style.display = "grid";
		}
	}
};

filterBar.addEventListener("load", filterBarScroll());
filterBar.addEventListener("scroll", filterBarScroll);

scrollFilterLeft.addEventListener("click", () => {
	filterBar.scrollLeft -= 100;
});

scrollFilterRight.addEventListener("click", () => {
	filterBar.scrollLeft += 100;
});
