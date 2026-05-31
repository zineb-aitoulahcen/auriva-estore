function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if(input.type === 'password') {
        input.type = 'text';
        btn.style.opacity = '1';
    } else {
        input.type = 'password';
        btn.style.opacity = '0.5';
    }
}