let jsonString = localStorage.getItem('category') || "{}";
let product = JSON.parse(localStorage.getItem('products')) || "{}";
let arr = []
document.getElementById('addDescription').value = "";
let data = JSON.parse(jsonString);
const filter = document.getElementById('filter');
upadateData();
resetArr();
displayElements(data);
resetSortIcons();
function resetArr() {
    arr = [];
    for (let i in data) {
        arr.push(data[i]);
    }
}

function resetSortIcons() {
    document.querySelectorAll('.sort').forEach(button => {
        button.classList.add("fa-sort");
        button.classList.remove("fa-sort-up");
        button.classList.remove("fa-sort-down");
        button.addEventListener('click', () => {
        });
    })
}

function removeEventListenersByClassName(className) {
    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach(element => {
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
    });
}

function upadateData() {
    jsonString = localStorage.getItem('category') || "{}";
    product = JSON.parse(localStorage.getItem('products')) || "{}";
    data = JSON.parse(jsonString);
    resetArr();
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

function addButton(categoryForm, categoryId, categoryName, addDescription) {
    console.log(data);
    categoryForm.dataset.type = "add";
    categoryId.value = null;
    categoryName.value = null;
    addDescription.value = null;
}

function editButton(button, categoryForm, categoryId, categoryName, addDescription) {
    data = JSON.parse(jsonString);
    categoryId.value = button.dataset.val;
    categoryName.value = data[Number(categoryId.value)]['categoryName'];
    addDescription.value = data[Number(categoryId.value)]['description'];
    categoryForm.dataset.type = "edit";
}

function addCategorySubmitHandler(categoryName, addDescription) {
    data = JSON.parse(jsonString);
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
    data = JSON.parse(jsonString);
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
            Swal.fire(`Category ${categoryName.value} has not been added. `, '', 'info')
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
        resetArr();
        displayElements(arr)
        myModal.hide();

    })
});

function sortAndDisplay(button) {
    let value = button.dataset.value;
    let sort = button.dataset.sort;
    let type = button.dataset.content;
    resetSortIcons();
    button.firstElementChild.classList.remove("fa-sort");
    if (sort == "dsc") {
        button.firstElementChild.classList.add("fa-sort-up");
        button.dataset.sort = "asc";
        arr = arr.sort((a, b) => (type == 'number') ? a[value] - b[value] : String(a[value]).localeCompare(String(b[value])));
    }
    else {
        button.firstElementChild.classList.add("fa-sort-down");
        button.dataset.sort = "dsc";
        button.setAttribute('data-sort', 'dsc');
        arr = arr.sort((a, b) => (type == 'number') ? b[value] - a[value] : String(b[value]).localeCompare(String(a[value])));
    }
    displayElements(arr);
}

function deleteButton(button) {
    Swal.fire({
        title: `Do you want to delete "${ data[button.dataset.val]['categoryName']}" category?`,
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        },
    }).then((result) => {
        if (!result.isConfirmed) { return; }
        upadateData();
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
    }).then(() => {
        resetArr();
        filterEliments();
        displayElements(arr)
        myModal.hide();

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
                    sortAndDisplay(button);
                    break;

                default:
                    break;
            }
        })
    });
}

function filterEliments() {
    console.log(data);
    let filteredArr = arr.filter(category => category['categoryId'] == Number(filter.value)
        || category.categoryName.toLowerCase().includes(String(filter.value.toLowerCase()))
        || category.description.toLowerCase().includes(String(filter.value.toLowerCase())));
    displayElements(filteredArr);
}

filter.addEventListener('input', () => {
    filterEliments();
});