const special_container = document.getElementById('special-id-1');
const special_form = document.getElementById('special_form');
const angle_down = document.querySelector('.fa-angle-down');
const angle_up = document.querySelector('.fa-angle-up');

if (special_container) {
    special_container.addEventListener('click', () => {
        console.log('special tồn tại');
        special_form.classList.toggle('body-content_show'); // Use toggle to switch between showing and hiding
    });
} else {
    console.error('special_container not found');
}

if (angle_down && angle_up) {
    angle_down.addEventListener('click', () => {
        special_form.classList.remove('body-content_show');
    });

    angle_up.addEventListener('click', () => {
        special_form.classList.add('body-content_show');
    });
} else {
    console.error('angle_down or angle_up not found');
}

// 
const special_container1 = document.getElementById('special-id-2');
const special_form1 = document.getElementById('special_form-1');
const angle_down1 = document.querySelector('.fa-angle-down');
const angle_up1 = document.querySelector('.fa-angle-up');

if (special_container1) {
    special_container1.addEventListener('click', () => {
        console.log('special tồn tại');
        special_form1.classList.toggle('body-content_show'); // Use toggle to switch between showing and hiding
    });
} else {
    console.error('special_container1 not found');
}

if (angle_down1 && angle_up1) {
    angle_down1.addEventListener('click', () => {
        special_form1.classList.remove('body-content_show');
    });

    angle_up1.addEventListener('click', () => {
        special_form1.classList.add('body-content_show');
    });
} else {
    console.error('angle_down1 or angle_up1 not found');
}
