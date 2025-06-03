import { loadStripe } from '@stripe/stripe-js';
document.addEventListener('DOMContentLoaded', async () => {
	const stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);
	const elements = stripe.elements();
	const cardElement = elements.create('card', {
		hidePostalCode: true,
		disableLink: true
	});
	cardElement.mount('#card-element');

	const form = document.getElementById('subscription-form');
	const cardholderName = document.getElementById('cardholder-name');
	form.addEventListener('submit', async (e) => {
		e.preventDefault();

		const result = await stripe.createPaymentMethod({
			type: 'card',
			card: cardElement,
			billing_details: {
				name: cardholderName.value,
			}
		});
		const paymentMethod = result.paymentMethod;
		const error = result.error;

		if (error) {
			alert(error.message);
		} else {
			const hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'stripeToken');
			hiddenInput.setAttribute('value', paymentMethod.id);
			form.appendChild(hiddenInput);

			form.submit();
		}
	});
});
