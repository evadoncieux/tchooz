document.addEventListener('DOMContentLoaded', function () {
	console.log('search script running');

	const form = document.getElementById('search-form');
	const input = document.getElementById('search-input');
	const results = document.getElementById('search-results');

	function slugify(str) {
		return String(str)
			.normalize('NFKD') // split accented characters into their base characters and diacritical marks
			.replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
			.trim() // trim leading or trailing whitespace
			.toLowerCase() // convert to lowercase
			.replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
			.replace(/\s+/g, '-') // replace spaces with hyphens
			.replace(/-+/g, '-'); // remove consecutive hyphens
	}

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		const query = input.value;

		fetch(`/clothes/search?q=${encodeURIComponent(query)}`)
			.then(response => response.json())
			.then(data => {
				console.log(data);
				results.innerHTML = '';
				data.forEach(item => {
					const div = document.createElement('div');
					const slug = slugify(item.name);
					div.innerHTML = `
					<a href="/clothes/details/${slug}">
						<p>${item.name}</p>
					</a>
`;
					div.classList.add('clothing-item');
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
