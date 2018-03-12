const $ = require('jquery')
// const $body = $('body')

// window.jQuery = $;

function cycle(wrapper, { speed, timeout }) {
  const elements = wrapper.find('> div')

  // if one or no elements - don't cycle
  if (elements.length <= 1) {
    return;
  }

  // display only the first element
  elements.filter(':not(:first-child)').hide();

  // the actual cycle function
  function doCycle() {
    // the visible element
    const selected = elements.filter(':visible');

    // the element to display - the next element to the visible one
    let toDisplay = selected.next();
    if(toDisplay.length === 0) {
      // toDisplay = $(elements[0]);

      // reload when at end, to reload results
      location.reload()
    }

    // fade over to next element
    selected.fadeOut(speed);
    toDisplay.fadeIn(speed);
  }

  setInterval(doCycle, timeout);
}

$(document).ready(() => {
  const $results = $('.results-wrapper')
  if ($results.length) {
    cycle($results, {
      speed: 'fast',
      timeout: 5000,
    });
  }
});
