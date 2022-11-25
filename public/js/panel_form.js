/**
 * @file panel_form.js
 * @version 0.0.1 First working code.
 * @author Derek Tan
 */

/**
 * @brief This is a automatically called function expression containing initialization code.
 * The listeners store closures with this IIFE's important variables, while not exposing important variables to console.
 */
(function () {
  const FormDOM = document.querySelector('#post-form');
  let FormAction = FormDOM.querySelector('#action-form');
  let TitleInput = FormDOM.querySelector('input#poem-title');
  let TextInput = FormDOM.querySelector('input#poem-text');
  let IDInput = FormDOM.querySelector('input#poem-id');
  let SubmitInput = FormDOM.querySelector('input#submit-btn');

  /** @description A list of all Form DOM objects. Used to track what to disable / enable. */
  const INPUT_LIST = [TitleInput, TextInput, IDInput, SubmitInput];

  /** @description Maps selected action radio btn. to what sub-forms to disable in INPUT_LIST. */
  const DISABLER_MAP = {
    nop: [0, 1, 2, 3],  // disable all below action name radio buttons
    publish: [2],       // only disable poem ID input
    delete: [0, 1]      // only disable title input and textarea
  };

  /**
   * @description Helper function for re-enabling all inputs.
   */
  function disableSome(disabled_indexes) {
    // enable all temporarily...
    INPUT_LIST.forEach((inputElement) => {
      inputElement.setAttribute('required', 'true');
      inputElement.removeAttribute('disabled');
    });

    // disable all inputs in the list that are on a DISABLER_MAP entry!
    disabled_indexes.forEach((index) => {
      INPUT_LIST[index].removeAttribute('required');
      INPUT_LIST[index].setAttribute('disabled', 'true');
    });
  }

  FormAction.addEventListener('click', (mouseEvent) => {
    // fetch radio button action, defaults as 'nil'
    let targetAction = mouseEvent.target.getAttribute('value') || 'nil';
  
    if (targetAction == 'nil') {
      mouseEvent.preventDefault();
      return;
    }

    disableSome(DISABLER_MAP[targetAction]);
  });
});