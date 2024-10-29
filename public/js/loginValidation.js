document.addEventListener('DOMContentLoaded', function () 
{
    const loginForm = document.getElementById('loginForm');
    if (loginForm) 
        {
        loginForm.addEventListener('submit', function(event) 
        {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailPattern = /^[a-zA-Z0-9._-]+@drg\.mx$/;
            if (!emailPattern.test(email)) 
                {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'El correo electrónico debe terminar en @drg.mx.',
                    showConfirmButton: false,
                    timer: 1500
                });
                event.preventDefault();
                return;
            }

            if (password.length < 8 || !/^[A-Za-z0-9!@#$%^&*()_+=-]+$/.test(password)) 
                {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'La contraseña debe tener al menos 8 caracteres y solo puede contener letras, números y símbolos permitidos. No se permiten espacios.',
                    showConfirmButton: false,
                    timer: 1500
                });
                event.preventDefault();
            }
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) 
        {
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!nombre.trim()) 
                {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'El nombre no puede estar vacío!',
                    showConfirmButton: false,
                    timer: 1500
                });
                event.preventDefault();
                return;
            }

            if (!email.match(/^[a-zA-Z0-9._-]+@drg\.mx$/)) 
                {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'El correo electrónico debe terminar en @drg.mx.',
                    showConfirmButton: false,
                    timer: 1500
                });
                event.preventDefault();
                return;
            }

            if (password.length < 8 || !password.match(/^[A-Za-z0-9!@#$%^&*()_+=-]+$/)) 
                {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'La contraseña debe tener al menos 8 caracteres y solo puede contener letras, números y símbolos permitidos.',
                    showConfirmButton: false,
                    timer: 1500
                });
                event.preventDefault();
            }
        });
    }

    // Comprobar si hay un mensaje de éxito o error en sessionStorage y mostrarlo
    const successMessage = sessionStorage.getItem('successMessage');
    if (successMessage) {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: successMessage,
            showConfirmButton: false,
            timer: 1500
        });
        sessionStorage.removeItem('successMessage'); // Limpiar el mensaje después de mostrarlo
    }

    const errorMessage = sessionStorage.getItem('errorMessage');
    if (errorMessage) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: errorMessage,
            showConfirmButton: false,
            timer: 1500
        });
        sessionStorage.removeItem('errorMessage'); // Limpiar el mensaje después de mostrarlo
    }
});