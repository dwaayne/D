let openShopping = document.querySelector('.shopping');
let closeShopping = document.querySelector('.closeShopping');
let list = document.querySelector('.list');
let listCard = document.querySelector('.listCard');
let body = document.querySelector('body');
let total = document.querySelector('.total');
let quantity = document.querySelector('.quantity');
//nav bar
function openNav() {
    document.getElementById("header").style.width = "250px";
  }
  
  function closeNav() {
    document.getElementById("header").style.width = "0";
  }

let products = [
    {
        id: 1,
        name: 'Acer Aspire',
        image: 'P1.jpg',
        price: 20000
    },
    {
        id: 2,
        name: 'Iphone 15 Pro Max',
        image: 'P2.jpg',
        price: 72000
    },
    {
        id: 3,
        name: 'Assorted Books',
        image: 'P3.jpg',
        price: 500
    },
    {
        id: 4,
        name: 'Black Shoes',
        image: 'P4.jpg',
        price: 600
    },
    {
        id: 5,
        name: 'Notebooks',
        image: 'P5.jpg',
        price: 100
    },
    {
        id: 6,
        name: 'Samsung S23 Ultra',
        image: 'P6.jpg',
        price: 60000
    },
    {
        id: 7,
        name: 'Worn-out Black Shoes',
        image: 'P7.jpg',
        price: 50
    },
    {
        id: 8,
        name: 'Broken Laptop',
        image: 'P8.jpg',
        price: 500
    },
    {
        id: 9,
        name: 'Jell Trading Card LTD',
        image: 'P10.PNG',
        price: 50000
    }
];
let listCards  = [];
function initApp(){
    products.forEach((value, key) =>{
        let newDiv = document.createElement('div');
        newDiv.classList.add('item');
        newDiv.innerHTML = `
            <img src="image/${value.image}">
            <div class="title">${value.name}</div>
            <div class="price">${value.price.toLocaleString()}</div>
            <button onclick="addToCard(${key})">Add To Card</button>`;
        list.appendChild(newDiv);
    })
}
initApp();
function addToCard(key){
    if(listCards[key] == null){
        // copy product form list to list card
        listCards[key] = JSON.parse(JSON.stringify(products[key]));
        listCards[key].quantity = 1;
    }
    reloadCard();
}
function reloadCard(){
    listCard.innerHTML = '';
    let count = 0;
    let totalPrice = 0;
    listCards.forEach((value, key)=>{
        totalPrice = totalPrice + value.price;
        count = count + value.quantity;
        if(value != null){
            let newDiv = document.createElement('li');
            newDiv.innerHTML = `
                <div><img src="image/${value.image}"/></div>
                <div>${value.name}</div>
                <div>${value.price.toLocaleString()}</div>
                <div>
                    <button onclick="changeQuantity(${key}, ${value.quantity - 1})">-</button>
                    <div class="count">${value.quantity}</div>
                    <button onclick="changeQuantity(${key}, ${value.quantity + 1})">+</button>
                </div>`;
                listCard.appendChild(newDiv);
        }
    })
    total.innerText = totalPrice.toLocaleString();
    quantity.innerText = count;
}
function changeQuantity(key, quantity){
    if(quantity == 0){
        delete listCards[key];
    }else{
        listCards[key].quantity = quantity;
        listCards[key].price = quantity * products[key].price;
    }
    reloadCard();
}
//slideshow//
let index = 0;
displayImages();
function displayImages() {
  let i;
  const images = document.getElementsByClassName("image");
  for (i = 0; i < images.length; i++) {
    images[i].style.display = "none";
  }
  index++;
  if (index > images.length) {
    index = 1;
  }
  images[index-1].style.display = "block";
  setTimeout(displayImages, 2000); 
}