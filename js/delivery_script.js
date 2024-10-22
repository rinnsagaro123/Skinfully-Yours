
let profile = document.querySelector('.profile');
  
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
    
window.onscroll = () =>{
    navbar.classList.remove('active');
    profile.classList.remove('active');
}