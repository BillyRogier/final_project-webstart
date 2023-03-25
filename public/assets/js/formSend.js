const getError = async (form) =>
	await fetch(form.action, {
		method: "POST",
		body: new FormData(form),
	})
		.then((res) => res.json())
		.then((json) => json.results)
		.catch((error) => console.error("error >", error));

export { getError };
