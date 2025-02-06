let jsonString = localStorage.getItem('category') || "{}";
let product = JSON.parse(localStorage.getItem('products')) || "{}";
document.getElementById('addDescription').value = "";
let data = JSON.parse(jsonString);
displayEliments(data);

function displayEliments(data) {
    for (let i in data) {
        const element = data[i];
        let str = (element['description'].length > 50) ? element['description'].substring(0, 70) + "..." : element['description'];
        let tableBody = document.getElementById('tableBody');
        tableBody.innerHTML += `
        <tr>
            <td>${i}</td>
            <td>${element['categoryName']}</td>
            <td>${str}</td>
            <td>
                <button class="btn btn-outline-success" data-type="edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-val="${i}">
                    <i class="fa-solid fa-pencil"></i>  </button>
                    <button class="btn btn-outline-danger" data-type="delete" data-val="${i}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>`;
    }
}

function addButton(categoryForm, categoryId, categoryName, addDescription) {
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
    let categoryId = (Object.keys(data).length > 0) ? data[keys[keys.length - 1]]['categoryId'] + 1  : 1;
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

categoryForm.addEventListener('submit', () => {
    const categoryName = document.getElementById('categoryName');
    const addDescription = document.getElementById('addDescription');
    const categoryId = document.getElementById('categoryId');
    (categoryForm.dataset.type == "add") ? addCategorySubmitHandler(categoryName, addDescription)
        : editCategorySubmitHandler(categoryName, addDescription, categoryId);
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
    displayEliments(arr);
}

function deleteButton(button) {
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
    location.reload();
}

document.querySelectorAll('.btn').forEach(button => {
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