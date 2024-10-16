// public/js/city-autocomplete.js
document.addEventListener('DOMContentLoaded', function() {
	console.log('running autocomplete script');

	const cityInputs = document.querySelectorAll('.city-autocomplete');

	cityInputs.forEach(input => {
		const suggestionsContainer = document.createElement('div');
		suggestionsContainer.className = 'city-suggestions';
		input.parentNode.insertBefore(suggestionsContainer, input.nextSibling);

		input.addEventListener('input', debounce(async (e) => {
			const query = e.target.value;
			if (query.length < 2) {
				suggestionsContainer.innerHTML = '';
				return;
			}

			try {
				const response = await fetch(`${input.dataset.autocompleteUrl}?query=${encodeURIComponent(query)}`);
				const cities = await response.json();

				suggestionsContainer.innerHTML = '';
				cities.forEach(city => {
					const div = document.createElement('div');
					div.textContent = `${city.name}, ${city.country}`;
					div.addEventListener('click', () => {
						input.value = div.textContent;
						suggestionsContainer.innerHTML = '';
					});
					suggestionsContainer.appendChild(div);
				});
			} catch (error) {
				console.error('Error fetching city suggestions:', error);
			}
		}, 300));

		// Close suggestions when clicking outside
		document.addEventListener('click', (e) => {
			if (e.target !== input) {
				suggestionsContainer.innerHTML = '';
			}
		});
	});
});

function debounce(func, delay) {
	let timeoutId;
	return function (...args) {
		clearTimeout(timeoutId);
		timeoutId = setTimeout(() => func.apply(this, args), delay);
	};
}
