// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, target) => {
	const rectSource = subject[0].getBoundingClientRect();
	cy.get(target).then(el => {
		const rectTarget = el[0].getBoundingClientRect();

		cy.window().then((window) => {
			const pageX = rectSource.left + window.pageXOffset;
			const pageY = rectSource.top + window.pageYOffset;
			const targetPageX = rectTarget.left + window.pageXOffset;
			const targetPageY = rectTarget.top + window.pageYOffset;
	
			cy.wrap(subject)
				.trigger('mouseover', { force: true })
				.trigger('mousedown', { which: 1, pageX, pageY, force: true })
				.trigger('mousemove', { which: 1, pageX: targetPageX, pageY: targetPageY, force: true })
				.trigger('mouseup', { force: true });
		});
	});
});
