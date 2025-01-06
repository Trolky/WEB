document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const errors = {
    username: true,
    email: true,
    password: true,
    passwordConfirm: true,
    surname: true,
    address: true,
    login: true,
    tel: true,
  };

  const setError = (input, message) => {
    const errorSpan = input.parentElement.querySelector('.error');
    errorSpan.textContent = message;
    errorSpan.style.display = 'block';
    input.parentElement.classList.add('hasError');
  };

  const clearError = (input) => {
    const errorSpan = input.parentElement.querySelector('.error');
    errorSpan.textContent = '';
    errorSpan.style.display = 'none';
    input.parentElement.classList.remove('hasError');
  };

  const validateInput = (input, formType) => {
    const value = input.value.trim();

    if (input.classList.contains('name') && formType === 'signup') {
      errors.username = value.length === 0;
      errors.username ? setError(input, 'Prosím zadejte svoje jméno') : clearError(input);
    }

    if (input.classList.contains('surname') && formType === 'signup') {
      errors.surname = value.length === 0;
      errors.surname ? setError(input, 'Prosím zadejte svoje příjmení') : clearError(input);
    }

    if (input.classList.contains('adress') && formType === 'signup') {
      errors.address = value.length === 0;
      errors.address ? setError(input, 'Prosím zadejte svoji celou adresu') : clearError(input);
    }

    if (input.classList.contains('email') && formType === 'signup') {
      errors.email = !value;
      errors.email ? setError(input, 'Prosím zadejte emailovou adresu') : clearError(input);
    }

    if (input.classList.contains('number') && formType === 'signup') {
      errors.tel = value.length !== 9;
      errors.tel ? setError(input, 'Prosím zadejte telefonní číslo') : clearError(input);
    }

    if (input.classList.contains('pass')) {
      errors.password = value.length < 6;
      errors.password ? setError(input, 'Heslo musí být aspoň 6 znaků dlouhé') : clearError(input);
    }

    if (input.classList.contains('passConfirm') && formType === 'signup') {
      const passwordValue = document.getElementById('password').value;
      errors.passwordConfirm = value.trim() !== passwordValue.trim();
      errors.passwordConfirm ? setError(input, 'Hesla se neshodují') : clearError(input);
    }

    if (input.classList.contains('login')) {
      errors.login = value.length === 0;
      errors.login ? setError(input, 'Prosím zadejte svoje login jméno') : clearError(input);
    }
  };

  const formInputs = document.querySelectorAll('input');

  formInputs.forEach((input) => {
    // Label effect
    input.addEventListener('focus', () => {
      const label = input.parentElement.querySelector('label');
      if (label) label.classList.add('active');
    });

    input.addEventListener('blur', () => {
      const formType = input.closest('.signup') ? 'signup' : 'login';
      validateInput(input, formType);
    });
  });

  // Prevent form submission if there are errors
  document.querySelectorAll('form.signup-form').forEach((form) => {
    form.addEventListener('submit', (event) => {
      const formType = 'signup'; // Always set to 'signup' for the signup form

      // Loop through each error and validate the corresponding field
      Object.keys(errors).forEach((key) => {
        const input = form.querySelector(`.${key}`);
        if (input) validateInput(input, formType);
      });

      // Check if there are any errors
      if (Object.values(errors).some((error) => error)) {
        event.preventDefault(); // Prevent form submission if errors exist
        alert(`Formulář pro registraci obsahuje chyby. Opravte je prosím a zkuste to znovu.`);
      }
    });
  });

  // Detect Firefox browser for CSS adjustments
  if (navigator.userAgent.toLowerCase().includes('firefox')) {
    document.querySelectorAll('.form form label').forEach(label => label.classList.add('fontSwitch'));
  }
});
