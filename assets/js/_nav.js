document.addEventListener('DOMContentLoaded', () => {
	const hamburgerInput = document.getElementById('hamburger-input');
	const sidebarMenu = document.getElementById('sidebar-menu');
	const hamburgerMenu = document.getElementById('hamburger-menu');

	document.addEventListener('click', (event) => {
		const isClickInsideMenu = sidebarMenu.contains(event.target);
		const isClickOnHamburger = hamburgerMenu.contains(event.target);

		if (!isClickInsideMenu && !isClickOnHamburger && hamburgerInput.checked) {
			hamburgerInput.checked = false;
		}

	});

	// Prevent clicks inside the menu from closing it
	sidebarMenu.addEventListener('click', (event) => {
		event.stopPropagation();
	});
});
