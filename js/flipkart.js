let products = JSON.parse(localStorage.getItem('crud2'))
let catagory = JSON.parse(localStorage.getItem('catagory'))
const footer = document.getElementById('footer');
catagory.forEach(cat => {
    let it = products.filter(item => item.catagory == cat)
    if (it.length!=0) {
        let ele = document.createElement('section')
        const str = cat.charAt(0).toUpperCase() + cat.slice(1);
        ele.innerHTML = `
        <div class="container-fluid">
            <div class="p4-perent">
                    <div class="p3-header p-2">
                        <h2>Best Of ${str}</h2>
                    </div>
                    <div class="d-flex p3-placeholder" id="${cat}">
                    </div>
            </div>
        </div>`
        footer.insertAdjacentElement('beforebegin', ele);
        let placeholder = document.getElementById(cat);
        it.forEach(element => {
            placeholder.innerHTML += `
            <div class="item-p3">
                <div class="card">
                    <img src="${element['image']}"
                            loading="lazy" alt="Image"
                            class="header-image">
                    <div class="card-body">
                        <div class="p3-item-dis">From ${+ element['price']} only.</div>
                        <div class="p3-item-price fw-bold ">${element['productName']}</div>
                    </div>
                    <div class="dn3">
                        <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                </div>
            </div>`
        });
    }
});
