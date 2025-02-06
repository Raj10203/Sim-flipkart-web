let jsonString = localStorage.getItem('products') || "{}";
let data = JSON.parse(jsonString);
let arr = []
let keys = Object.keys(data)
let categoryOptions = JSON.parse(localStorage.getItem('category')) || {};
const fileInput = document.querySelector('#addImage');
let base64String;
displayEliments(data);
resetSortIcons();
updateSelect();
buttonEventlisner();
const filter = document.getElementById('filter')

for (var i in data) {
    arr.push(data[i])
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
        || product.category.toLowerCase().includes(String(filter.value.toLowerCase())));
    displayEliments(searchData);
});

function updateSelect() {
    for (let i in categoryOptions) {
        addItemcategoryOptions.innerHTML += ` <option value="${categoryOptions[i]['categoryName']}">${categoryOptions[i]['categoryName']}</option>`;
        addItemcategoryOptions.dataset.val = i;
    }
}

function displayEliments(data) {
    let tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";
    for (var i in data) {
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
            <td><button class="btn btn-outline-success" data-type="edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-val="${element['productId']}">
                <i class="fa-solid fa-pencil"></i>  </button>  <button class="btn btn-outline-danger" data-type="delete" data-val="${element['productId']}">  
                <i class="fa-solid fa-trash"></i>  </button> 
            </td>
        </tr>`;
        buttonEventlisner();

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
    pName.setAttribute('value', data[Number(productId.value)]['productName']);
    data[Number(productId.value)]['productName'] = pName.value;
    data[Number(productId.value)]['image'] = (base64String == undefined) ? data[Number(productId.value)]["image"] : base64String;
    data[Number(productId.value)]['price'] = Number(pPrice.value);
    data[Number(productId.value)]['description'] = pDescription.value;
    data[Number(productId.value)]['category'] = select.dataset.val;
    localStorage.setItem('products', JSON.stringify(data));
}

function addClickHandler(pName, pPrice, pDescription, select) {
    data = JSON.parse(jsonString);
    let productId = (Object.keys(data).length > 0) ? data[keys[keys.length - 1]]['productId'] + 1 : 1;
    let newData = {
        productId: productId,
        productName: pName.value,
        price: Number(pPrice.value),
        description: pDescription.value,
        image: base64String,
        category: select.dataset.val
    };
    data[productId] = newData;
    jsonString = JSON.stringify(data);
    localStorage.setItem('products', jsonString);
    base64String = null;
}

fileInput.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();
    const showImg = document.getElementById('showImg');
    reader.onloadend = await function () {
        base64String = reader.result;
        showImg.setAttribute('src', base64String);
    };
    await reader.readAsDataURL(file);
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

function editButton(button) {
    let pName = document.getElementById('addProductName');
    let pPrice = document.getElementById('addPrice');
    let pDescription = document.getElementById('addDescription');
    let productId = document.getElementById('productId');
    let pImg = document.getElementById('addImage');
    let showImg = document.getElementById('showImg');
    let select = document.getElementById('addItemcategoryOptions');
    data = JSON.parse(jsonString);
    productId.value = button.dataset.val;
    pImg.required = false;
    let productItem = data[Number(productId.value)];
    showImg.setAttribute('src', productItem['image']);
    productId.dataset.val = productItem['productId'];
    pName.value = productItem['productName'];
    pPrice.value = productItem['price'];
    pDescription.value = productItem['description'];
    select.value = categoryOptions[productItem['category']].categoryName;
    document.getElementById('form').dataset.type = "edit";
}

function deleteButton(button) {
    delete data[button.dataset.val];
    jsonString = JSON.stringify(data);
    localStorage.setItem('products', jsonString);
    location.reload();
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
function buttonEventlisner() {
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
}

