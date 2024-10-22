
let profile = document.querySelector('.header .profile');
  
document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}

let notif = document.querySelector('.notif');

document.querySelector('#notif-btn').onclick = () =>{
    notif.classList.toggle('active');
    profile.classList.remove('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.navbar');
  
document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active'); 
    profile.classList.remove('active');
}

let navbar_order = document.querySelector('.navbar-order');
  
document.querySelector('#menu-btn-order').onclick = () =>{
    navbar_order.classList.toggle('active'); 
}

    
window.onscroll = () =>{
    navbar.classList.remove('active');
    profile.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(numberInput => {
    numberInput.oninput = () =>{
       if(numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
    };
 });