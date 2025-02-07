let products = JSON.parse(localStorage.getItem('products')) || {};
let category = JSON.parse(localStorage.getItem('category')) || {};
const footer = document.getElementById('footer');


for (var i in category) {
    let exist = 0;
    for (var j in products) {
        if (i == products[j]['category']) {
            exist = 1;
            break;
        }
    }
    if (exist) {
        let ele = document.createElement('section');
        const str = category[i]['categoryName'].charAt(0).toUpperCase() + category[i]['categoryName'].slice(1);
        ele.innerHTML = `
        <div class="container-fluid">
            <div class="p4-perent">
                    <div class="p3-header p-2">
                        <h2>Best Of ${str}</h2>
                    </div>
                    <div class="d-flex p3-placeholder" id="${category[i]['categoryName']}">
                </div>
            </div>
        </div>`;
        footer.insertAdjacentElement('beforebegin', ele);
    }
}

for (var i in products) {
    if (category[products[i]['category']]?.['categoryName']) {
        let element = products[i];
        let placeholder = document.getElementById(category[element['category']]['categoryName']);
        placeholder.innerHTML += `
        <div class="item-p3">
            <div class="card">
                <img src="${element['image']}" loading="lazy" alt="Image" class="header-image">
                <div class="card-body">
                    <div class="p3-item-dis">From ${+ element['price']} only.
                    </div>
                    <div class="p3-item-price fw-bold ">${element['productName']}
                    </div>
                </div>
                <div class="dn3">
                    <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </div>
        </div>`;
    }
}