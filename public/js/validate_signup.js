/**
 * @file validate_signup.js
 * @version 0.0.2 Added matching password check.
 * @author Derek Tan
 */

/**
 * @constant CHECK_TABLE
 * @type {Object<string, RegExp[]>}
 * @description Validation pattern storage for `check_login.js`.
 */
const CHECK_TABLE = {
  'username-field': [/\w+/], // must be a spaceless AND word-like string!
  'password-field': [/\w+\S+/, /(\$\!\.)/], // must have word chars and punctuation mixed!
  /**
   * @type {Function}
   * @description Gets the testing regex for validation of given input's naming.
   * @param {string} key Input's naming.
   * @returns {RegExp[]} An array of regexes to each test.
   */
  getTest: function (key) {
    return this[key] || [/\S+/];
  }
};

/**
 * @description Helper for testing regexes against any input's value for form validation.
 * @param {string} fieldValue An inputted string from a user within an input.
 * @param {RegExp[]} regexList An entry from a config object to use for validation.
 */
function testValueOf(fieldValue, fieldNaming) {
  let valid = true;

  const regexList = CHECK_TABLE.getTest(fieldNaming);

  // check for any validation failure!
  for (tester in regexList) {
    if (!tester.test(fieldValue)) {
      valid = false;
      break;
    }
  }

  return valid;
}

/**
 * @brief This is a automatically called function expression (IIFE) containing initialization code.
 * The listeners store closures with this IIFE's important variables, while not exposing important variables to console.
 */
(function () {
  /** @type {HTMLFormElement} */
  let FormDOM = document.querySelector('#register-form');

  /** @type {HTMLInputElement} */
  let usernameField = document.querySelector('#username-field');

  /** @type {HTMLInputElement} */
  let passwordField = document.querySelector('#password-field');

  /** @type {HTMLInputElement} */
  let pwConfirmField = document.querySelector('#pwconfirm-field');

  /** @type {HTMLParagraphElement} */
  let formMsgPar = document.querySelector('#form-msg');

  FormDOM.addEventListener('submit', (submitEvent) => {
    let hasEmptyForm = usernameField.value.length === 0 && passwordField.value.length === 0;

    let usernameValid = testValueOf(usernameField.value, UNAME_INPUT_ID);
    let passwordValid = testValueOf(passwordField.value, PW_FIRST_INPUT_ID);

    let confirmValid = passwordField.value == pwConfirmField.value;

    if (hasEmptyForm) {
      formMsgPar.innerText = 'Enter login.';
    } else if (!usernameValid) {
      formMsgPar.innerText = 'Username invalid!';
    } else if (!passwordValid ) {
      formMsgPar.innerText = 'Password invalid!';
    } else if (confirmValid) {
      formMsgPar.innerText = 'Password mismatch!';
    } else {
      formMsgPar.innerText = 'Inputs are valid.';
    }

    if (hasEmptyForm || !usernameValid || !passwordValid || !confirmValid) {
      submitEvent.preventDefault();
    }
  });
})();