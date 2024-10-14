document.addEventListener('DOMContentLoaded', function() {
	console.log('search script running');

	const form = document.getElementById('search-form');
	const input = document.getElementById('search-input');
	const results = document.getElementById('search-results');

	form.addEventListener('submit', function(e) {
		e.preventDefault();
		const query = input.value;

		fetch(`/api/search?q=${encodeURIComponent(query)}`)
			.then(response => response.json())
			.then(data => {
				results.innerHTML = '';
				data.forEach(item => {
					const div = document.createElement('div');
					div.textContent = item.name;
					results.appendChild(div);
				});
			})
			.catch(error => {
				console.error('Error:', error);
				console.log(query);
				results.innerHTML = 'An error occurred while searching.';
			});
	});
});
