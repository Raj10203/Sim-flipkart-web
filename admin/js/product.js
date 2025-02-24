let jsonString;
let categoryOptions;
let data;
let arr = [];
let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
let sortButtonId = 'productIdButton';
let base64String;
const fileInput = document.querySelector('#addImage');
const filter = document.getElementById('filter');

function upadateData() {
    categoryOptions = JSON.parse(localStorage.getItem('category')) || {};
    jsonString = localStorage.getItem('products') || "{}";
    data = JSON.parse(jsonString);
}

function showUpdatedChanges() {
    upadateData();
    updateSelect();
    resetArr();
    arr = filterEliments();
    arr = sortAndDisplay(arr, sortButtonId);
    displayElements(arr);
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
    button.firstElementChild.classList.toggle("fa-sort-down", sort === "asc");
    button.firstElementChild.classList.toggle("fa-sort-up", sort !== "asc");
    button.dataset.sort = sort === "asc" ? "desc" : "asc";
}

function updateSelect() {
    let addItemcategoryOptions = document.getElementById('addItemcategoryOptions');
    for (let i in categoryOptions) {
        addItemcategoryOptions.innerHTML += ` <option value="${categoryOptions[i]['categoryId']}">
        ${categoryOptions[i]['categoryName']}</option>`;
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
    }
    buttonEventListner();
}

function resetSortIcons() {
    document.querySelectorAll('.sort').forEach(button => {
        button.classList.add("fa-sort");
        button.classList.remove("fa-sort-up", "fa-sort-down");
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
        return Promise.resolve(`Product ${pName.value} has been edited successfully!!`);
    } catch (error) {
        return Promise.reject(error)
    }
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
        return Promise.resolve(`Product ${pName.value} has been added successfully!!`);
    } catch (error) {
        return Promise.reject(error)
    }
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

function setEditForm(button) {
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');
    let select = document.getElementById('addItemcategoryOptions');
    let productItem = data[button.dataset.val]

    $('#staticBackdropLabel').text("Edit Category");
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
        title: `Do you want to delete "${data[button.dataset.val]['productName']}" Product                                                                               ?`,
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        },
    }).then((result) => {
        if (result.isConfirmed) {
            delete data[button.dataset.val];
            jsonString = JSON.stringify(data);
            localStorage.setItem('products', jsonString);
            Swal.fire('Deleted!', '', 'success');
            showUpdatedChanges();
        } else {
            Swal.fire('Not Deleted', '', 'warning')
        }
    }).then(() => {
    })
}

function filterEliments() {
    return arr.filter(product => String(product.productId).includes(String(filter.value)) ||
        product.productName.toLowerCase().includes(String(filter.value.toLowerCase())) ||
        product.description.toLowerCase().includes(String(filter.value.toLowerCase())) ||
        categoryOptions[product.category]['categoryName'].toLowerCase().includes(String(filter.value.toLowerCase())) ||
        String(product.price).includes(filter.value));
}
function resetAddForm() {
    if (!document.getElementById('addItemcategoryOptions').firstElementChild) {
        $('.openModal').on('click', '.btn', function (e) { e.stopPropagation(); })
        Swal.fire(`you have not added a single category you should add it first`,
            '', 'warning').then(() => {
                location.href = "category.html";

            })
    }
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');
    
    $('#addImage').val("");
    $('#showImg').addClass('d-none');
    $('#productForm').attr('data-type','add');
    $('#staticBackdropLabel').append("Add Category");
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
                    setEditForm(button);
                    break;
                case 'add':
                    resetAddForm();
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
filter.addEventListener('input', () => {
    showUpdatedChanges();
});
fileInput.addEventListener('change', async function () {
    let maxSize = 500 * 1024;
    const file = this.files[0];
    if (file) {
        if (file.size > maxSize) {
            document.getElementById('messageImageSize').textContent = "File size exceeds 500KB. Please upload a smaller file.";
            this.value = "";
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
    $('#showImg').removeClass('d-none');
});
productForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const pName = document.getElementById('addProductName');
    const pPrice = document.getElementById('addPrice');
    const pDescription = document.getElementById('addDescription');
    const productId = document.getElementById('productId');
    const select = document.getElementById('addItemcategoryOptions');

    if (productForm.dataset.type == "add") {
        addClickHandler(pName, pPrice, pDescription, select).then((res) => {
            Swal.fire(res, '', 'success')
        }).catch(err => {
            Swal.fire(`Error : ${err} ${pName.value} has not been added. `, '', 'error')
            return;
        });
    } else {
        editClickHandler(pName, pPrice, pDescription, productId, select).then((res) => {
            Swal.fire(res, '', 'success')
        }).catch(err => {
            Swal.fire(`Error : ${err} ${pName.value} has not been edited. `, '', 'error');
            return;
        });
    }
    showUpdatedChanges();
    myModal.hide();
})
showUpdatedChanges();
