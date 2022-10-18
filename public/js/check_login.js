/**
 * @file check_form.js
 * @version 0.0.1
 * @author Derek Tan
 */

/**
 * @constant CHECK_TABLE
 * @type {Object<string, RegExp[]>}
 * @description Validation pattern storage for `check_login.js`.
 */
const CHECK_TABLE = {
  'username-field': [/\w+/], // must be a spaceless AND word-like string!
  'password-field': [/\w+\S+/, /(\$\!\.)/], // must have word chars with punctuation mixed!
  /**
   * @type {Function}
   * @description Gets the testing regex for validation of given input's naming.
   * @param {string} key Input's naming.
   * @returns {RegExp[]}
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
 * The listeners store closures with this IIFE's important variables.
 */
(function () {
  /// Constants
  const LOGIN_FORM_CLASS = 'login-form';
  const UNAME_INPUT_CLASS = 'username-field';
  const PWORD_INPUT_CLASS = 'password-field';
  const FORM_MSG_ID = 'form-msg';

  /// DOM Variables
  /** @type {HTMLFormElement} */
  let FormDOM = document.querySelector(`#${LOGIN_FORM_CLASS}`);

  /** @type {HTMLInputElement} */
  let usernameField = document.querySelector(`#${UNAME_INPUT_CLASS}`);

  /** @type {HTMLInputElement} */
  let passwordField = document.querySelector(`#${PWORD_INPUT_CLASS}`);
  
  /** @type {HTMLParagraphElement} */
  let formMsgPar = document.querySelector(`#${FORM_MSG_ID}`);

  // todo: put submit listener to check with regexes before submit...
  FormDOM.addEventListener('submit', (submitEvent) => {
    let hasEmptyForm = usernameField.value.length === 0 && passwordField.value.length === 0;
    let usernameValid = testValueOf(usernameField.value, UNAME_INPUT_CLASS);
    let passwordValid = testValueOf(passwordField.value, PWORD_INPUT_CLASS);

    if (hasEmptyForm) {
      formMsgPar.innerText = 'Enter login.';
    } else if (!usernameValid) {
      formMsgPar.innerText = 'Username invalid!';
    } else if (!passwordValid) {
      formMsgPar.innerText = 'Password invalid!';
    } else {
      formMsgPar.innerText = 'Inputs are valid.';
    }

    if (hasEmptyForm || !usernameValid || !passwordValid) {
      submitEvent.preventDefault();
    }
  });

})();