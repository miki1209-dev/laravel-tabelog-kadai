import { loadStripe } from '@stripe/stripe-js';
document.addEventListener('DOMContentLoaded', async () => {
	const stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);
	const elements = stripe.elements();
	const cardElement = elements.create('card');
	cardElement.mount('#card-element');

	const form = document.getElementById('subscription-form');
	form.addEventListener('submit', async (e) => {
		e.preventDefault();

		const result = await stripe.createToken(cardElement);
		const token = result.token;
		const error = result.error;

		if (error) {
			alert(error.message);
		} else {
			const hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'stripeToken');
			hiddenInput.setAttribute('value', token.id);
			form.appendChild(hiddenInput);

			form.submit();
		}
	});
});
