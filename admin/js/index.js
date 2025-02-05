let jsonString = localStorage.getItem('crud2');
let data = JSON.parse(jsonString) || [];
let catagoryOptions = JSON.parse(localStorage.getItem('catagory'));
const fileInput = document.querySelector('#addImage');
let base64String;
const form = document.getElementById('form');
displayEliments(data);
resetSortIcons();
const filter = document.getElementById('filter')
filter.addEventListener('input', () => {
    let searchData = data.filter(product => product['productId'] == Number(filt.value) || product.productName.toLowerCase().includes(String(filt.value.toLowerCase())) || product.catagory.toLowerCase().includes(String(filt.value.toLowerCase())))
    displayEliments(searchData);
});
const categoryForm = document.getElementById('categoryForm');
categoryForm.addEventListener('submit', () => {
    let addCategory = document.getElementById('addCategory');
    let selectCategory = document.getElementById('addCatagoryOptions');
    switch (categoryForm.lastElementChild.value) {
        case 'Add':
            catagoryOptions.push(addCategory.value)
            localStorage.setItem('catagory', JSON.stringify(catagoryOptions));
            break;

        case 'Delete':
            let index = catagoryOptions.findIndex(select => select == selectCategory.value)
            if (index != -1) {
                catagoryOptions.splice(index, 1);
                localStorage.setItem('catagory', JSON.stringify(catagoryOptions));
            }
            break;

        default:
            break;
    }
})
document.querySelectorAll('.select').forEach(select => {
    switch (select.dataset.type) {
        case 'catagoryOptions':
            for (let i = 0; i < catagoryOptions.length; i++) {
                select.innerHTML += ` <option value="${catagoryOptions[i]}">${catagoryOptions[i]}</option>`
            }
            break;

        case 'crudCategory':
            select.addEventListener('change', () => {
                const categorySelectDiv = document.getElementById('crudCategorySelect');
                const categoryInputDiv = document.getElementById('crudCategoryInput');
                const categorySubmit = document.getElementById('catagorySubmit');
                switch (select.value) {
                    case 'delete':
                        categorySelectDiv.style = "display:block";
                        categoryInputDiv.style = "display:none";
                        categorySubmit.classList.remove('btn-primary')
                        categorySubmit.classList.add('btn-danger')
                        categorySubmit.value = "Delete";
                        break;

                    case 'add':
                        categorySubmit.value = "Add";
                        categorySubmit.classList.add('btn-primary')
                        categorySubmit.classList.remove('btn-danger')
                        categorySelectDiv.style = "display:none";
                        categoryInputDiv.style = "display:block";
                        break;
                    default:
                        break;
                }
            })
            break;

        default:
            break;
    }
})
function displayEliments(data) {
    let tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";
    for (let i = 0; i < data.length; i++) {
        const element = data[i];
        let des= (element['description'].length>50) ? element['description'].substring(0,70):element['description'];
        tableBody.innerHTML += `<tr id="${i}">
        <td>${element['productId']}</td>
        <td>${element['productName']}</td>
        <td><img class="tableImage" src="${element["image"]}" /></td>
        <td>${element['price']}</td>
        <td>${des + '...'}</td>
        <td>${element['catagory']}</td>
        <td><button class="btn btn-outline-success" data-type="edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-val="${i}">  <i class="fa-solid fa-pencil"></i>  </button>  <button class="btn btn-outline-danger" data-type="delete" data-val="${i}">  <i class="fa-solid fa-trash"></i>  </button> </td></tr>`
    }
}
function resetSortIcons() {
    document.querySelectorAll('.sort').forEach(button => {
        button.classList.add("fa-sort");
        button.classList.remove("fa-sort-up");
        button.classList.remove("fa-sort-down");
        button.addEventListener('click', () => {
        })
    })
}

function editClickHandler(pName, pPrice, pDescription, productId, select) {
    data = JSON.parse(jsonString);
    pName.setAttribute('value', data[Number(productId.value)]['productName'])
    data[Number(productId.value)]['productName'] = pName.value;
    data[Number(productId.value)]['image'] = (base64String == undefined) ? data[Number(productId.value)]["image"] : base64String;
    data[Number(productId.value)]['price'] = Number(pPrice.value);
    data[Number(productId.value)]['description'] = pDescription.value;
    data[Number(productId.value)]['catagory'] = select.value;
    localStorage.setItem('crud2', JSON.stringify(data));
}
function addClickHandler(pName, pPrice, pDescription, select) {
    data = JSON.parse(jsonString);
    let productId = (data.length > 0) ? data[data.length - 1].productId + 1 : 1;
    let newData = {
        productId: productId,
        productName: pName.value,
        price: Number(pPrice.value),
        description: pDescription.value,
        image: base64String,
        catagory: select.value
    }
    data.push(newData);
    jsonString = JSON.stringify(data);
    localStorage.setItem('crud2', jsonString);
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
        data = data.sort((a, b) => (type == 'number') ? a[value] - b[value] : String(a[value]).localeCompare(String(b[value])))
    }
    else {
        button.firstElementChild.classList.add("fa-sort-down");
        button.dataset.sort = "dsc";
        button.setAttribute('data-sort', 'dsc');
        data = data.sort((a, b) => (type == 'number') ? b[value] - a[value] : String(b[value]).localeCompare(String(a[value])))
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
    let select = document.getElementById('addItemCatagoryOptions')
    data = JSON.parse(jsonString);
    productId.value = button.dataset.val;
    pImg.required = false
    showImg.setAttribute('src', data[Number(productId.value)]['image']);
    productId.dataset.val = data[Number(productId.value)]['productId'];
    pName.value = data[Number(productId.value)]['productName'];
    pPrice.value = data[Number(productId.value)]['price'];
    pDescription.value = data[Number(productId.value)]['description'];
    select.value = data[Number(productId.value)]['catagory']
    document.getElementById('form').dataset.type = "edit";
}
function deleteButton(button) {
    let id = button.dataset.val;
    data.splice(id, 1);
    jsonString = JSON.stringify(data);
    localStorage.setItem('crud2', jsonString)
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
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', () => {
        switch (button.dataset.type) {
            case 'edit':
                editButton(button)
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
})
form.addEventListener('submit', () => {
    const pName = document.getElementById('addProductName');
    const pPrice = document.getElementById('addPrice');
    const pDescription = document.getElementById('addDescription');
    const productId = document.getElementById('productId');
    const select = document.getElementById('addItemCatagoryOptions');
    (form.dataset.type == "add") ? addClickHandler(pName, pPrice, pDescription, select) : editClickHandler(pName, pPrice, pDescription, productId, select);

})