function notify(message, type) {
    let notification = $(`<div></div>`).html(message + `
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `).addClass('sufee-alert alert with-close alert-' + type + ' alert-dismissible fade show mb-1');
    $('.notifications').append(notification);
    setTimeout(() => {
        notification.fadeOut(500, function () {
            $(this).remove();
        });
    }, 4000);
}

function handleApiResponse(response) {
    response = JSON.parse(response);
    console.log(response);
    if (!response.success) {
        if (response.error === 'session_expired' || response.error === 'permission_denied') {
            window.location.href = response.redirect ?? '/login';
        }
        else if (response.error === 'validation_error') {
            notify(response.message + "</br>" + Object.values(response.data).join('</br>') || "Validation error", 'warning');
        }
        else {
            notify(response.message ?? "An error occurred", 'error');
        }
    } else {
        notify(response.message ?? "Success", 'success');
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