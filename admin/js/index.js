let jsonString = localStorage.getItem('crud2');
let catagoryOptions = JSON.parse(localStorage.getItem('catagory'))
let data = JSON.parse(jsonString) || [];
const fileInput = document.querySelector('#addImage');
let base64String;
const form = document.getElementById('form');
displayEliments(data);
resetSortIcons();
const select = document.getElementById('catagoryOptions');
for (let i = 0; i < catagoryOptions.length; i++) {
    select.innerHTML+= ` <option value="${catagoryOptions[i]}">${catagoryOptions[i]}</option>`
}
document.getElementById('productIdIcon').classList.remove('fa-sort');
document.getElementById('productIdIcon').classList.add('fa-sort-up');
function displayEliments(data) {
    console.log(data);
    let tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";
    for (let i = 0; i < data.length; i++) {
        const element = data[i];
        tableBody.innerHTML += `<tr id="${i}">
        <td>${data[i]['productId']}</td>
        <td>${data[i]['productName']}</td>
        <td><img class="tableImage" src="${data[i]["image"]}" /></td>
        <td>${data[i]['price']}</td>
        <td>${data[i]['description']}</td>
        <td>${data[i]['catagory']}</td>
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

form.addEventListener('submit', () => {
    const pName = document.getElementById('addProductName');
    const pPrice = document.getElementById('addPrice');
    const pDescription = document.getElementById('addDescription');
    const productId = document.getElementById('productId');
    (form.dataset.type == "add") ? addClickHandler(pName, pPrice, pDescription, select) : editClickHandler(pName, pPrice, pDescription, productId);

})

function editClickHandler(pName, pPrice, pDescription, productId) {
    console.log("edit");
    data = JSON.parse(jsonString);
    pName.setAttribute('value', data[Number(productId.value)]['productName'])
    console.log(data[Number(productId.value)]);
    data[Number(productId.value)]['productName'] = pName.value;
    data[Number(productId.value)]['image'] = (base64String == undefined) ? data[Number(productId.value)]["image"] : base64String;
    data[Number(productId.value)]['price'] = Number(pPrice.value);
    data[Number(productId.value)]['description'] = pDescription.value;
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
        catagory : select.value
    }
    data.push(newData);
    console.log(data);
    jsonString = JSON.stringify(data);
    localStorage.setItem('crud2', jsonString);
    base64String = "";
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
    console.log(button.firstElementChild);
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

document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', () => {
        switch (button.dataset.type) {
            case 'edit':
                let pName = document.getElementById('addProductName');
                let pPrice = document.getElementById('addPrice');
                let pDescription = document.getElementById('addDescription');
                let productId = document.getElementById('productId');
                let pImg = document.getElementById('addImage');
                let showImg = document.getElementById('showImg');
                data = JSON.parse(jsonString);
                productId.value = button.dataset.val;
                pImg.required = false
                showImg.setAttribute('src', data[Number(productId.value)]['image']);
                productId.dataset.val = data[Number(productId.value)]['productId'];
                pName.value = data[Number(productId.value)]['productName'];
                pPrice.value = data[Number(productId.value)]['price'];
                pDescription.value = data[Number(productId.value)]['description'];
                document.getElementById('form').dataset.type = "edit";
                break;

            case 'add':
                document.getElementById('form').dataset.type = "add";
                break;

            case 'delete':
                let id = button.dataset.val;
                data.splice(id, 1);
                console.log(data);
                jsonString = JSON.stringify(data);
                localStorage.setItem('crud2', jsonString)
                location.reload();
                break;

            case 'sorting':
                sortAndDisplay(button);
                break;

            default:
                break;
        }
    })
})