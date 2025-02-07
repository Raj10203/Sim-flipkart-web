let jsonString = localStorage.getItem('products') || "{}";
let data = JSON.parse(jsonString);
let arr = []
let categoryOptions = JSON.parse(localStorage.getItem('category')) || {};
const fileInput = document.querySelector('#addImage');
const filter = document.getElementById('filter')
let base64String;

displayElements(data);
resetSortIcons();
updateSelect();
resetArr()

function resetArr() {
    arr = [];
    for (let i in data) {
        arr.push(data[i]);
    }
}

form.addEventListener('submit', () => {
    const pName = document.getElementById('addProductName');
    const pPrice = document.getElementById('addPrice');
    const pDescription = document.getElementById('addDescription');
    const productId = document.getElementById('productId');
    const select = document.getElementById('addItemcategoryOptions');
    (form.dataset.type == "add") ? addClickHandler(pName, pPrice, pDescription, select) : editClickHandler(pName, pPrice, pDescription, productId, select);
});

filter.addEventListener('input', () => {
    let searchData = arr.filter(product => product['productId'] == Number(filter.value)
        || product.productName.toLowerCase().includes(String(filter.value.toLowerCase()))
        || product.description.toLowerCase().includes(String(filter.value.toLowerCase()))
        || categoryOptions[product.category]['categoryName'].toLowerCase().includes(String(filter.value.toLowerCase())));

    displayElements(searchData);
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
        button.addEventListener('click', () => {
        });
    })
}

function editClickHandler(pName, pPrice, pDescription, productId, select) {
    data = JSON.parse(jsonString);
    let product = data[Number(productId.value)];
    pName.setAttribute('value', product['productName']);
    product['productName'] = pName.value;
    product['image'] = (base64String == undefined) ? product["image"] : base64String;
    product['price'] = Number(pPrice.value);
    product['description'] = pDescription.value;
    product['category'] = select.value;
    localStorage.setItem('products', JSON.stringify(data));
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
    data[productId] = newData;
    jsonString = JSON.stringify(data);
    localStorage.setItem('products', jsonString);
    base64String = null;
}

fileInput.addEventListener('change', async function () {
    let maxSize = 500 * 1080;
    const file = this.files[0];
    if (file) {
        if (file.size > maxSize) {
            document.getElementById('messageImageSize').textContent = "File size exceeds 500KB. Please upload a smaller file.";
            this.value = ""; // Reset the input of image
        }
        else {
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
    resetArr();
}

function editButton(button) {
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');
    let select = document.getElementById('addItemcategoryOptions');
    data = JSON.parse(jsonString);
    let productItem = data[button.dataset.val]
    productId.value = button.dataset.val;
    pImg.required = false;
    showImg.setAttribute('src', productItem['image']);
    productId.dataset.val = productItem['productId'];
    pName.value = productItem['productName'];
    pPrice.value = productItem['price'];
    pDescription.value = productItem['description'];
    select.value = categoryOptions[productItem['category']]['categoryId'];
    document.getElementById('form').dataset.type = "edit";
}

function deleteButton(button) {
    if (confirm(`are you sure you want to delete ${data[button.dataset.val]['prodctName']}`)) {
        delete data[button.dataset.val];
        jsonString = JSON.stringify(data);
        localStorage.setItem('products', jsonString);
        location.reload();
    }
}

function addButton() {
    document.getElementById('form').dataset.type = "add";
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');
    productId.value = null;
    pImg.required = true;
    showImg.setAttribute('src', "");
    productId.dataset.val = null;
    pName.value = null;
    pPrice.value = null;
    pDescription.value = null;
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
                    sortAndDisplay(button);
                    break;

                default:
                    break;
            }
        })
    });
}
