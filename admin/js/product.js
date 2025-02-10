let jsonString = localStorage.getItem('products') || "{}";
let categoryOptions = JSON.parse(localStorage.getItem('category')) || {};
let data = JSON.parse(jsonString);
let arr = []
let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
let sortButtonId = 'productIdButton';
let base64String;
const fileInput = document.querySelector('#addImage');
const filter = document.getElementById('filter')
showUpdatedChanges();

function upadateData() {
    categoryOptions = JSON.parse(localStorage.getItem('category')) || {};
    jsonString = localStorage.getItem('products') || "{}";
    data = JSON.parse(jsonString);
}

function showUpdatedChanges() {
    upadateData();
    resetArr();
    filterEliments();
    sortAndDisplay(sortButtonId);
    displayElements(arr);
    updateSelect();
}

function resetArr() {
    arr = [];
    for (let i in data) {
        arr.push(data[i]);
    }
}

function changeSortIcons(id) {
    let button = document.getElementById(id);
    let sort = button.dataset.sort;
    resetSortIcons();
    button.firstElementChild.classList.remove("fa-sort");
    if (sort == "asc") {
        button.firstElementChild.classList.add("fa-sort-down");
        button.setAttribute('data-sort', 'dsc');
    } else {
        button.firstElementChild.classList.add("fa-sort-up");
        button.setAttribute('data-sort', 'asc');
    }
}
productForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const pName = document.getElementById('addProductName');
    const pPrice = document.getElementById('addPrice');
    const pDescription = document.getElementById('addDescription');
    const productId = document.getElementById('productId');
    const select = document.getElementById('addItemcategoryOptions');
    Swal.fire({
        title: `Do you want to add "${pName.value}" category?`,
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        }
    }).then((result) => {
        if (productForm.dataset.type == "add") {
            if (!result.isConfirmed) {
                Swal.fire(`Category ${pName.value} has not been added. `, '', 'error')
                return;
            }
            addClickHandler(pName, pPrice, pDescription, select).then((res) => {
                Swal.fire(res, '', 'success')
            }).catch(err => {
                Swal.fire(`Error : ${err} ${pName.value} has not been added. `, '', 'error')
                return;
            });
        } else {
            if (!result.isConfirmed) {
                Swal.fire(`Product ${pName.value} has not been edited. `, '', 'error')
                return;
            }
            editClickHandler(pName, pPrice, pDescription, productId, select).then((res) => {
                Swal.fire(res, '', 'success')
            }).catch(err => {
                Swal.fire(`Error : ${err} ${pName.value} has not been edited. `, '', 'error');
                return;
            });
        }
    }).then(() => {
        showUpdatedChanges();
        myModal.hide();
    })
    // (form.dataset.type == "add") ? addClickHandler(pName, pPrice, pDescription, select) : editClickHandler(pName, pPrice, pDescription, productId, select);
});

function updateSelect() {
    let addItemcategoryOptions = document.getElementById('addItemcategoryOptions');
    for (let i in categoryOptions) {
        addItemcategoryOptions.innerHTML += ` <option value="${categoryOptions[i]['categoryId']}">${categoryOptions[i]['categoryName']}</option>`;
    }
}

function displayElements(data) {
    let tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";
    for (let i in data) {
        const element = data[i];
        let category = "removed";
        if (categoryOptions[element['category']]) {
            category = categoryOptions[element['category']]['categoryName'];
        }
        let str = (element['description'].length > 50) ? element['description'].substring(0, 70) + "..." : element['description'];
        tableBody.innerHTML += `
            <tr id="${i}">
                <td>${element['productId']}</td>
                <td>${element['productName']}</td>
                <td><img class="tableImage" src="${element["image"]}" /></td>
                <td>${element['price']}</td>
                <td>${str}</td>
                <td>${category}</td>
                <td>
                    <button class="btn btn-outline-success event" data-type="edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-val="${element['productId']}">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                    <button class="btn btn-outline-danger event" data-type="delete" data-val="${element['productId']}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>`;
        buttonEventListner();
    }
}

function resetSortIcons() {
    document.querySelectorAll('.sort').forEach(button => {
        button.classList.add("fa-sort");
        button.classList.remove("fa-sort-up");
        button.classList.remove("fa-sort-down");
    })
}

function editClickHandler(pName, pPrice, pDescription, productId, select) {
    try {
        data = JSON.parse(jsonString);
        let product = data[Number(productId.value)];
        pName.setAttribute('value', product['productName']);
        product['productName'] = pName.value;
        product['image'] = (base64String == undefined) ? product["image"] : base64String;
        product['price'] = Number(pPrice.value);
        product['description'] = pDescription.value;
        product['category'] = select.value;
        localStorage.setItem('products', JSON.stringify(data));
    } catch (error) {
        return Promise.reject(error)
    }
    return Promise.resolve(`Product ${pName.value} has been updated successfully!`);
}

function addClickHandler(pName, pPrice, pDescription, select) {
    let keys = Object.keys(data);
    data = JSON.parse(jsonString);
    let productId = (Object.keys(data).length > 0) ? data[keys[keys.length - 1]]['productId'] + 1 : 1;
    let newData = {
        productId: productId,
        productName: pName.value,
        price: Number(pPrice.value),
        description: pDescription.value,
        image: base64String,
        category: select.value
    };
    try {
        data[productId] = newData;
        jsonString = JSON.stringify(data);
        localStorage.setItem('products', jsonString);
    } catch (error) {
        return Promise.reject(error)
    }
    return Promise.resolve(`Product ${pName.value} has been added successfully!`);
}
fileInput.addEventListener('change', async function () {
    let maxSize = 500 * 1080;
    const file = this.files[0];
    if (file) {
        if (file.size > maxSize) {
            document.getElementById('messageImageSize').textContent = "File size exceeds 500KB. Please upload a smaller file.";
            this.value = ""; // Reset the input of image
        } else {
            document.getElementById('messageImageSize').textContent = "File size is valid.";
            const reader = new FileReader();
            const showImg = document.getElementById('showImg');
            reader.onloadend = await function () {
                base64String = reader.result;
                showImg.setAttribute('src', base64String);
            };
            await reader.readAsDataURL(file);
        }
    }
});

function sortAndDisplay(id) {
    let button = document.getElementById(id);
    let value = button.dataset.value;
    let sort = button.dataset.sort;
    let type = button.dataset.content;
    if (sort == "asc") {
        arr = arr.sort((a, b) => (type == 'number') ? a[value] - b[value] : String(a[value]).localeCompare(String(b[value])));
    } else {
        arr = arr.sort((a, b) => (type == 'number') ? b[value] - a[value] : String(b[value]).localeCompare(String(a[value])));
    }
}

function editButton(button) {
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');
    let select = document.getElementById('addItemcategoryOptions');
    let productItem = data[button.dataset.val]
    data = JSON.parse(jsonString);

    productId.value = button.dataset.val;
    pImg.required = false;
    showImg.setAttribute('src', productItem['image']);
    productId.dataset.val = productItem['productId'];
    pName.value = productItem['productName'];
    pPrice.value = productItem['price'];
    pDescription.value = productItem['description'];
    select.value = categoryOptions[productItem['category']]['categoryId'];
    document.getElementById('productForm').dataset.type = "edit";
}

function deleteButton(button) {
    Swal.fire({
        title: `Do you want to delete "${data[button.dataset.val]['productName']}" category?`,
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
            Swal.fire(`Product ${data[button.dataset.val]['productName']} has not been deleted. `, '', 'error')
            return;
        }
        delete data[button.dataset.val];
        jsonString = JSON.stringify(data);
        localStorage.setItem('products', jsonString);
        Swal.fire('Deleted!', '', 'success');
    }).then(() => {
        showUpdatedChanges();
    })
}

function filterEliments() {
    arr = arr.filter(product => String(product.productId).includes(String(filter.value)) ||
        product.productName.toLowerCase().includes(String(filter.value.toLowerCase())) ||
        product.description.toLowerCase().includes(String(filter.value.toLowerCase())) ||
        categoryOptions[product.category]['categoryName'].toLowerCase().includes(String(filter.value.toLowerCase())) ||
        String(product.price).includes(filter.value));
}
filter.addEventListener('input', () => {
    showUpdatedChanges();
});

function addButton() {
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');

    document.getElementById('productForm').dataset.type = "add";
    productId.value = null;
    pImg.required = true;
    showImg.setAttribute('src', "");
    productId.dataset.val = null;
    pName.value = null;
    pPrice.value = null;
    pDescription.value = null;
}

function removeEventListenersByClassName(className) {
    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach(element => {
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
    });
}

function buttonEventListner() {
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
                    sortButtonId = button.id;
                    changeSortIcons(sortButtonId);
                    showUpdatedChanges();
                    break;
                default:
                    break;
            }
        })
    });
}