const menu = document.querySelector('.menu-toggle');
const navigation = document.querySelector('#navigation');
menu?.addEventListener('click', () => {
  const open = menu.getAttribute('aria-expanded') !== 'true';
  menu.setAttribute('aria-expanded', String(open));
  menu.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  navigation.classList.toggle('open', open);
});
document.addEventListener('keydown', event => {
  if (event.key === 'Escape' && menu?.getAttribute('aria-expanded') === 'true') {
    menu.click();
    menu.focus();
  }
});
document.querySelector('#product-search')?.addEventListener('input', event => {
  const query = event.target.value.toLowerCase().trim();
  let count = 0;
  document.querySelectorAll('.product-card').forEach(card => {
    card.hidden = !card.textContent.toLowerCase().includes(query);
    if (!card.hidden) count++;
  });
  document.querySelector('#no-products').hidden = count > 0;
});
document.querySelector('.quote-form')?.addEventListener('submit', event => {
  const file = event.target.querySelector('[name="artwork"]');
  file.setCustomValidity(file.files[0]?.size > 10 * 1024 * 1024 ? 'Please choose a file smaller than 10 MB.' : '');
  if (!event.target.reportValidity()) event.preventDefault();
});
document.querySelector('[name="artwork"]')?.addEventListener('change', event => event.target.setCustomValidity(''));
