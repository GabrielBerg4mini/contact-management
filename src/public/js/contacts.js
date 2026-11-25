
document.addEventListener('submit', (e) => {
    const message = e.target.dataset.confirm;
    if (message && !confirm(message)) e.preventDefault();
});

document.addEventListener('input', (e) => {
    if (e.target.id === 'contact') {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 9);
    }
});
