let removeEventListenersByClassName = (className) => {
    // remove and add node. By doing this it will destroy past eventlisner.
    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach(element => {
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
    });
}
let buttonEventListner = () => {
    removeEventListenersByClassName("event");
    document.querySelectorAll('.event').forEach(button => {
        button.addEventListener('click', () => {
            switch (button.dataset.type) {
                case 'edit':
                    editButton(button);
                    break;

                case 'add':
                    addButton();
                    break;

                case 'delete':
                    deleteButton(button);
                    break;

                case 'sorting':
                    sortAndDisplay(button);
                    break;

                default:
                    break;
            }
        })
    });
}
export { removeEventListenersByClassName , buttonEventListner  as default};
