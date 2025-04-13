function handleApiResponse(response) {    
    if (!response.success) {
        if (response.error === 'session_expired' || response.error === 'permission_denied') {
            window.location.href = response.redirect ?? '/login';
        } else if (response.error === 'validation_error') {
            let errorMessages = Object.values(response.data).join('<br>') || "Validation error";
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                html: errorMessages,
                confirmButtonColor: '#d33'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message ?? "An error occurred",
                confirmButtonColor: '#d33'
            });
        }
    } else {
        if (response.message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                timer: 2000,
                showConfirmButton: false
            });
        }
        return true;
    }
    return false;
}

function removeEventListenersByClassName(className) {
    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach(element => {
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
    });
}