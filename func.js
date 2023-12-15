document.addEventListener('DOMContentLoaded', function () {
	const submitBtn = document.getElementById('submit');
	const getDataBtn = document.getElementById('getdata');
	const signupBtn = document.getElementById('signup');
	const email = document.getElementById('email');
	const pass_user = document.getElementById('password');
	const msgDiv = document.getElementById('msg');

	// ASSIGN FUNCTIONALITY TO BUTTONS
	submitBtn.addEventListener('click', login);
	getDataBtn.addEventListener('click', getdata);
	signupBtn.addEventListener('click', signup);

	// LOGIN FUNCTION [ /LOGIN ENDPOINT ]
	function login() {
		console.log("LOGIN ATTEMPTED ...");
		const email = document.getElementById('email').value;
		const pass_user = document.getElementById('password').value;
		console.log("JSON STRING:", JSON.stringify({ email, pass_user }))
		fetch('http://localhost/PROJECT-LGN/api.php/login', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ email, pass_user })
		})
			.then(response => {
				if (response.ok) {
					return response.json();
				} else {
					console.log("EMAIL: ", email);
					console.log("PASS: ", pass_user);
					throw new Error('Invalid email or password.');
				}
			})
			.then(data => {
				msgDiv.innerHTML = `<p class="info">${data.message}</p>`;

				// SWITCH LOGIN FUNCTIONALITY TO LOGOUT
				submitBtn.innerHTML = "LOGOUT";
				submitBtn.removeEventListener('click', login);
				submitBtn.addEventListener('click', logout);

				// CLEAR AND REMOVE EMAIL AND PASSWORD TEXT BOXES
				const email = document.getElementById('email');
				const pass_user = document.getElementById('password')
				email.style.display = 'none';
				pass_user.style.display = 'none';
				email.value = "";
				pass_user.value = "";
			})
			.catch(error => {
				console.error('Error:', error);
				msgDiv.innerHTML = `<p class="error">${error.message}</p>`;
			});
	}

	// SIGNUP FUNCTION [ /SIGNUP ENDPOINT ]
	function signup() {
		console.log("SIGNUP ATTEMPTED ...");
		const email = document.getElementById('email').value;
		const pass_user = document.getElementById('password').value;
		console.log("JSON STRING:", JSON.stringify({ email, pass_user }))
		fetch('http://localhost/PROJECT-LGN/api.php/signup', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ email, pass_user })
		})
			.then(response => {
				if (response.ok) {
					return response.json();
				} else {
					console.log("EMAIL: ", email);
					console.log("PASS: ", pass_user);
					return response.json().then(error => {
						throw new Error(error.error);
					});
				}
			})
			.then(data => {
				msgDiv.innerHTML = `<p class="info">${data.message}</p>`;
			})
			.catch(error => {
				msgDiv.innerHTML = `<p class="error">${error.message}</p>`;
			});
	}

	// FUNCTION TO GET ALL DATA [ /COLLECTALLDATA ENDPOINT ]
	function getdata() {
		console.log("DATA COLLECTION ATTEMPTED ...");
		fetch('http://localhost/PROJECT-LGN/api.php/collectAllData', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
		})
			.then(response => {
				if (response.ok) {
					return response.json();
				} else {
					throw new Error('Bad response.');
				}
			})
			.then(data => {
				const msgDiv = document.getElementById('msg');
				msgDiv.innerHTML = '';
				// DISPLAY DATA IF NOT EMPTY
				if (data.length > 0) {
					// APPEND EACH ROW TO THE MSG DIV
					data.forEach(user => {
						msgDiv.innerHTML += `<p class="info">Email: ${user.email}, Password: ${user.pass}</p>`;
					});
				} else {
					msgDiv.innerHTML = '<p class="error">No data available.</p>';
				}
			})
			.catch(error => {
				console.error('Error:', error);
				const msgDiv = document.getElementById('msg');
				msgDiv.innerHTML = `<p class="error">${error.message}</p>`;
			});
	}

	// LOGOUT FUNCTION [ COSMETIC CHANGES TO PAGE ]
	function logout() {
		console.log('LOGOUT ATTEMPTED ...');
		submitBtn.innerHTML = "LOGIN";
		submitBtn.removeEventListener('click', logout);
		submitBtn.addEventListener('click', login);
		email.value = "";
		pass_user.value = "";
		msgDiv.innerHTML = "";
		email.style.display = 'inline-block';
		pass_user.style.display = 'inline-block';
	}
});