let jsonString, product, data;
let arr = [];
const filter = document.getElementById('filter');
let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
let sortButtonId = 'categoryIdButton';

function showUpdatedChanges() {
    upadateData();
    resetArr();
    arr = filterEliments();
    arr = sortAndDisplay(arr, sortButtonId);
    displayElements(arr);
}

function upadateData() {
    jsonString = localStorage.getItem('category') || "{}";
    product = JSON.parse(localStorage.getItem('products')) || "{}";
    data = JSON.parse(jsonString);
}

function resetArr() {
    arr = [];
    for (let i in data) {
        arr.push(data[i]);
    }
}

function filterEliments() {
    let filterValue = filter.value.toLowerCase();
    return arr.filter(category => category['categoryId'] == Number(filterValue) ||
        category.categoryName.toLowerCase().includes(filterValue.toLowerCase()) ||
        category.description.toLowerCase().includes(filterValue.toLowerCase()));
}

function updateSortIcons(id) {
    let button = document.getElementById(id);
    let sort = button.dataset.sort;
    resetSortIcons();

    button.firstElementChild.classList.remove("fa-sort");
    button.firstElementChild.classList.toggle("fa-sort-down", sort === "asc");
    button.firstElementChild.classList.toggle("fa-sort-up", sort !== "asc");
    button.dataset.sort = sort === "asc" ? "desc" : "asc";
}

function resetSortIcons() {
    document.querySelectorAll('.sort').forEach(button => {
        button.classList.add("fa-sort");
        button.classList.remove("fa-sort-up", "fa-sort-down");
    })
}

function sortAndDisplay(arr, id) {
    let button = document.getElementById(id);
    let value = button.dataset.value;
    let sortOrder = button.dataset.sort;
    let type = button.dataset.content;
    return arr.sort((a, b) =>
        type === 'number' ?
            (sortOrder === "asc" ? a[value] - b[value] : b[value] - a[value]) :
            (sortOrder === "asc" ? String(a[value]).localeCompare(String(b[value])) : String(b[value]).localeCompare(String(a[value])))
    );
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
                    showUpdatedChanges();
                    break;
                default:
                    break;
            }
        })
    });
}

function removeEventListenersByClassName(className) {
    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach(element => {
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
    });
}

function editButton(button, categoryForm, categoryId, categoryName, addDescription) {
    categoryId.value = button.dataset.val;
    categoryName.value = data[Number(categoryId.value)]['categoryName'];
    addDescription.value = data[Number(categoryId.value)]['description'];
    categoryForm.dataset.type = "edit";
}

function addButton(categoryForm, categoryId, categoryName, addDescription) {
    categoryForm.dataset.type = "add";
    categoryId.value = null;
    categoryName.value = null;
    addDescription.value = null;
}

function deleteButton(button) {
    Swal.fire({
        title: `Do you want to delete "${data[button.dataset.val]['categoryName']}" category?`,
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
    }).then((result) => {
        if (!result.isConfirmed) {
            Swal.fire(`Category ${data[button.dataset.val]['categoryName']} has not been deleted. `, '', 'error')
            return;
        }
        upadateData();
        for (let i in product) {
            if (product[i]['category'] == data[button.dataset.val]['categoryId']) {
                delete product[i];
            }
        }
        delete data[button.dataset.val];
        jsonString = JSON.stringify(data);
        localStorage.setItem('category', jsonString);
        localStorage.setItem('products', JSON.stringify(product));
        Swal.fire('Deleted!', '', 'success');
    }).then(() => {
        showUpdatedChanges();
    })
}


function addCategorySubmitHandler(categoryName, addDescription) {
    let keys = Object.keys(data)
    let categoryId = (Object.keys(data).length > 0) ? data[keys[keys.length - 1]]['categoryId'] + 1 : 1;
    let newData = {
        categoryId: categoryId,
        categoryName: categoryName.value,
        description: addDescription.value,
    };
    try {
        data[categoryId] = newData;
        jsonString = JSON.stringify(data);
        localStorage.setItem('category', jsonString);
    } catch (error) {
        return Promise.reject(error);
    }
    return Promise.resolve(`Category ${categoryName.value} has been added successfully!`);
}

function editCategorySubmitHandler(categoryName, addDescription, categoryId) {
    categoryName.setAttribute('value', data[Number(categoryId.value)]['categoryName']);
    data[Number(categoryId.value)]['categoryName'] = categoryName.value;
    data[Number(categoryId.value)]['description'] = addDescription.value;
    localStorage.setItem('category', JSON.stringify(data));
    return Promise.resolve("Success");
}

filter.addEventListener('input', showUpdatedChanges);
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
        }
    }).then((result) => {
        if (categoryForm.dataset.type == "add") {
            if (!result.isConfirmed) {
                Swal.fire(`Category ${categoryName.value} has not been added. `, '', 'error')
                return;
            }
            addCategorySubmitHandler(categoryName, addDescription).then((res) => {
                Swal.fire(`Category ${categoryName.value} has been added.  `, '', 'success')
            }).catch(err => {
                Swal.fire(`Error : ${err} ${categoryName.value} has not been added. `, '', 'error')
                return;
            });
        }
        else {
            if (!result.isConfirmed) {
                Swal.fire(`Category ${categoryName.value} has not been added. `, '', 'error')
                return;
            }
            editCategorySubmitHandler(categoryName, addDescription, categoryId).then((res) => {
                Swal.fire(`Category ${categoryName.value} has been added. `, '', 'success')
            }).catch(err => {
                Swal.fire(`Error : ${err} ${categoryName.value} has not been added. `, '', 'error');
                return;
            });
        }
    }).then(() => {
        showUpdatedChanges();
        myModal.hide();
    })
});
document.getElementById('addDescription').value = "";
showUpdatedChanges();