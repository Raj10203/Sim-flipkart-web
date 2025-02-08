let jsonString = localStorage.getItem('category') || "{}";
let product = JSON.parse(localStorage.getItem('products')) || "{}";
let arr = []
document.getElementById('addDescription').value = "";
let data = JSON.parse(jsonString);
const filter = document.getElementById('filter');
let sortButtonId = 'categoryIdButton';
upadateData();
function upadateData() {
    jsonString = localStorage.getItem('category') || "{}";
    product = JSON.parse(localStorage.getItem('products')) || "{}";
    data = JSON.parse(jsonString);
    showChanges();
}

function showChanges() {
    resetArr();
    filterEliments();
    sortAndDisplay(sortButtonId);
    displayElements(arr);
}

function resetArr() {
    arr = [];
    for (let i in data) {
        arr.push(data[i]);
    }
}

function filterEliments() {
    arr = arr.filter(category => category['categoryId'] == Number(filter.value)
        || category.categoryName.toLowerCase().includes(String(filter.value.toLowerCase()))
        || category.description.toLowerCase().includes(String(filter.value.toLowerCase())));
}

function updateSortIcons(id) {
    let button = document.getElementById(id);
    let sort = button.dataset.sort;
    resetSortIcons();
    button.firstElementChild.classList.remove("fa-sort");
    if (sort == "asc") {
        button.firstElementChild.classList.add("fa-sort-down");
        button.setAttribute('data-sort', 'dsc');
    }
    else {
        button.firstElementChild.classList.add("fa-sort-up");
        button.setAttribute('data-sort', 'asc');
    }
}

function sortAndDisplay(id) {
    
    let button = document.getElementById(id);
    let value = button.dataset.value;
    let sort = button.dataset.sort;
    let type = button.dataset.content;
    if (sort == "asc") {
        arr = arr.sort((a, b) => (type == 'number') ? a[value] - b[value] : String(a[value]).localeCompare(String(b[value])));
    }
    else {
        arr = arr.sort((a, b) => (type == 'number') ? b[value] - a[value] : String(b[value]).localeCompare(String(a[value])));
    }
}

function resetSortIcons() {
    document.querySelectorAll('.sort').forEach(button => {
        button.classList.add("fa-sort");
        button.classList.remove("fa-sort-up");
        button.classList.remove("fa-sort-down");
    })
}

function displayElements(data) {
    let tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";
    for (let i in data) {
        const element = data[i];
        let str = (element['description'].length > 50) ? element['description'].substring(0, 70) + "..." : element['description'];
        tableBody.innerHTML += `
            <tr>
            <td>${element['categoryId']}</td>
            <td>${element['categoryName']}</td>
            <td>${str}</td>
            <td>
            <button class="btn event btn-outline-success" data-type="edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-val="${element['categoryId']}">
            <i class="fa-solid fa-pencil"></i>  
            </button>
            <button class="btn event btn-outline-danger" data-type="delete" data-val="${element['categoryId']}">
            <i class="fa-solid fa-trash"></i>
            </button>
            </td>
            </tr>`;
        buttonEventlistner();
    }

}

function removeEventListenersByClassName(className) {
    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach(element => {
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
    });
}

function buttonEventlistner() {
    removeEventListenersByClassName("event");
    document.querySelectorAll('.event').forEach(button => {
        button.addEventListener('click', () => {
            const categoryForm = document.getElementById('categoryForm');
            const categoryId = document.getElementById('categoryId');
            const categoryName = document.getElementById('categoryName');
            const addDescription = document.getElementById('addDescription');
            switch (button.dataset.type) {
                case 'edit':
                    editButton(button, categoryForm, categoryId, categoryName, addDescription);
                    break;

                case 'add':
                    addButton(categoryForm, categoryId, categoryName, addDescription);
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

function addButton(categoryForm, categoryId, categoryName, addDescription) {
    categoryForm.dataset.type = "add";
    categoryId.value = null;
    categoryName.value = null;
    addDescription.value = null;
}

function editButton(button, categoryForm, categoryId, categoryName, addDescription) {
    categoryId.value = button.dataset.val;
    categoryName.value = data[Number(categoryId.value)]['categoryName'];
    addDescription.value = data[Number(categoryId.value)]['description'];
    categoryForm.dataset.type = "edit";
}

function addCategorySubmitHandler(categoryName, addDescription) {
    let keys = Object.keys(data)
    let categoryId = (Object.keys(data).length > 0) ? data[keys[keys.length - 1]]['categoryId'] + 1 : 1;
    let newData = {
        categoryId: categoryId,
        categoryName: categoryName.value,
        description: addDescription.value,
    };
    data[categoryId] = newData;
    jsonString = JSON.stringify(data);
    localStorage.setItem('category', jsonString);
}

function editCategorySubmitHandler(categoryName, addDescription, categoryId) {
    categoryName.setAttribute('value', data[Number(categoryId.value)]['categoryName']);
    data[Number(categoryId.value)]['categoryName'] = categoryName.value;
    data[Number(categoryId.value)]['description'] = addDescription.value;
    localStorage.setItem('category', JSON.stringify(data));
}
var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));


categoryForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const categoryName = document.getElementById('categoryName');
    const addDescription = document.getElementById('addDescription');
    const categoryId = document.getElementById('categoryId');
    Swal.fire({
        title: `Do you want to add "${categoryName.value}" category?`,
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        },
    }).then((result) => {
        if (!result.isConfirmed) {
            Swal.fire(`Category ${categoryName.value} has not been added. `, '', 'error')
            return;
        }
        if (categoryForm.dataset.type == "add") {
            addCategorySubmitHandler(categoryName, addDescription);
        }
        else {
            editCategorySubmitHandler(categoryName, addDescription, categoryId);
        }
        Swal.fire('Saved!', '', 'success');
    }).then(() => {
        upadateData();
        myModal.hide();

    })
});

function deleteButton(button) {
    Swal.fire({
        title: `Do you want to delete "${data[button.dataset.val]['categoryName']}" category?`,
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        },
    }).then((result) => {
        if (!result.isConfirmed) {
            Swal.fire(`Category ${categoryName.value} has not been deleted. `, '', 'error')
            return;
        }
        jsonString = localStorage.getItem('category') || "{}";
        product = JSON.parse(localStorage.getItem('products')) || "{}";
        data = JSON.parse(jsonString);
        for (let i in product) {
            if (product[i]['category'] == data[button.dataset.val]['categoryId']) {
                delete product[i];
            }
        }
        delete data[button.dataset.val];
        jsonString = JSON.stringify(data);
        localStorage.setItem('category', jsonString);

        jsonString = JSON.stringify(product);
        localStorage.setItem('products', jsonString);

        Swal.fire('Saved!', '', 'success');
    }).then(() => {
        upadateData();
    })
}

function buttonEventlistner() {
    removeEventListenersByClassName("event");
    document.querySelectorAll('.event').forEach(button => {
        button.addEventListener('click', () => {
            const categoryForm = document.getElementById('categoryForm');
            const categoryId = document.getElementById('categoryId');
            const categoryName = document.getElementById('categoryName');
            const addDescription = document.getElementById('addDescription');
            switch (button.dataset.type) {
                case 'edit':
                    editButton(button, categoryForm, categoryId, categoryName, addDescription);
                    break;

                case 'add':
                    addButton(categoryForm, categoryId, categoryName, addDescription);
                    break;

                case 'delete':
                    deleteButton(button);
                    break;

                case 'sorting':
                    sortButtonId = button.id;
                    updateSortIcons(sortButtonId);
                    showChanges();
                    break;

                default:
                    break;
            }
        })
    });
}

filter.addEventListener('input', () => {
    showChanges();
});