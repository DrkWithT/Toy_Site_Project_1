/**
 * @file check_form.js
 * @version 0.0.1
 * @author Derek Tan
 */

const INPUT_CLASS_NM = 'input.form-field';
const SUBMIT_CLASS_NM = 'input#submit-btn';

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
 * @constant CHECK_REASONS
 * @description Validation message table.
 */
const CHECK_REASONS = {
  msg_list: [
    'Inputs valid!',
    'Invalid Username.',
    'Invalid Password.'
  ],
  getMsg: function (index) {
    return this.msg_list[index] || 'Unknown problem.'; // default validation problem msg if applicable! 
  }
};

/**
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
 * @brief This is a automatically called function expression containing initialization code.
 * The listeners store closures with the important variables inside.
 */
(function (doc) {
  let formDOM = doc.querySelector('form');

  let formFields = formDOM.querySelectorAll(INPUT_CLASS_NM);
  let formSubmit = formDOM.querySelector(SUBMIT_CLASS_NM);

  // todo: put submit listener to check with regexes before submit...

})(document);