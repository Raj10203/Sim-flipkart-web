let jsonString = localStorage.getItem('category') || "{}";
addDescription.value = "";
let data = JSON.parse(jsonString);
displayEliments(data);

function displayEliments(data) {
    for (var i in data){
        const element = data[i];
        let str = (element['description'].length > 50) ? element['description'].substring(0, 70) + "..." : element['description'];
        tableBody.innerHTML +=  `
        <tr>
            <td>${i}</td>
            <td>${element['categoryName']}</td>
            <td>${str}</td>
            <td><button class="btn btn-outline-success" data-type="edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-val="${i}">
                <i class="fa-solid fa-pencil"></i>  </button>  <button class="btn btn-outline-danger" data-type="delete" data-val="${i}">  
                <i class="fa-solid fa-trash"></i>  </button> 
            </td>
        </tr>`;
    }
}

function addButton() {
    categoryForm.dataset.type = "add";
    categoryId.value = null;
    categoryId.dataset.val = null;
    addCategoryName.value = null;
    addDescription.value = null;
}

function editButton(button) {
    data = JSON.parse(jsonString);
    categoryId.value = button.dataset.val;
    categoryId.dataset.categoryId = data[Number(categoryId.value)]['categoryId'];
    addCategoryName.value = data[Number(categoryId.value)]['categoryName'];
    addDescription.value = data[Number(categoryId.value)]['description'];
    categoryForm.dataset.type = "edit";
}

function addCategorySubmitHandler(addCategoryName, addDescription) {
    data = JSON.parse(jsonString);
    let categoryId = (Object.keys(data).length > 0) ? Object.keys(data).length + 1 : 1;
    let newData = {
        categoryName: addCategoryName.value,
        description: addDescription.value,
    };
    data[categoryId] = newData;
    jsonString = JSON.stringify(data);
    localStorage.setItem('category', jsonString);
    base64String = null;
}

function editCategorySubmitHandler(addCategoryName, addDescription, categoryId) {
    data = JSON.parse(jsonString);
    addCategoryName.setAttribute('value', data[Number(categoryId.value)]['categoryName']);
    data[Number(categoryId.value)]['categoryName'] = addCategoryName.value;
    data[Number(categoryId.value)]['description'] = addDescription.value;
    localStorage.setItem('category', JSON.stringify(data));
}

categoryForm.addEventListener('submit', () => {
    (categoryForm.dataset.type == "add") ? addCategorySubmitHandler(addCategoryName, addDescription) 
    : editCategorySubmitHandler(addCategoryName, addDescription, categoryId);
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
        data = data.sort((a, b) => (type == 'number') ? a[value] - b[value] : String(a[value]).localeCompare(String(b[value])));
    }
    else {
        button.firstElementChild.classList.add("fa-sort-down");
        button.dataset.sort = "dsc";
        button.setAttribute('data-sort', 'dsc');
        data = data.sort((a, b) => (type == 'number') ? b[value] - a[value] : String(b[value]).localeCompare(String(a[value])));
    }
    displayEliments(data);
}

function deleteButton(button) {
    delete data[button.dataset.val];
    jsonString = JSON.stringify(data);
    localStorage.setItem('category', jsonString);
    location.reload();
}

document.querySelectorAll('.btn').forEach(button => {
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