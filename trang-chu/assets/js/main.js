document.addEventListener('DOMContentLoaded', function(){

  let swiperBoard = new Swiper('.swiper_card', {
    loop: true,
    spaceBetween: 20, // Khoảng cách giữa các hình ảnh
    grabCursor: true,
    slidesPerView: 'auto',
    centeredSlides: 'auto', // Đảm bảo hình ảnh ở giữa
    
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    
    // autoplay: {
    //     delay: 3000,
    //     disableOnInteraction: false,
    // },
  
    breakpoints: {
        1150: {
            slidesPerView: 2,
            centeredSlides: false,
        }
    },
  });
  let swiperSlide = new Swiper('.slide-carosel', {
    loop: true,
    spaceBetween: 20, // Khoảng cách giữa các hình ảnh
    grabCursor: true,
    slidesPerView: 'auto',
    centeredSlides: 'auto', // Đảm bảo hình ảnh ở giữa
    
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    },
    
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
  
    breakpoints: {
        1150: {
            slidesPerView: 1,
            centeredSlides: false,
        }
    },
  });
});

document.getElementById('ngayDiInput').addEventListener('input', function() {
  // Lấy giá trị từ input
  var inputValue = this.value;

  // Chuyển đổi giá trị thành định dạng bạn mong muốn
  var formattedDate = formatDate(inputValue);

  // Hiển thị giá trị đã chuyển đổi
  this.value = formattedDate;
});

// Hàm chuyển đổi định dạng ngày
function formatDate(inputDate) {
  // Đối với mục đích đơn giản, bạn có thể thực hiện chuyển đổi định dạng ngày tùy ý ở đây
  // Dưới đây chỉ là một ví dụ đơn giản, bạn có thể sử dụng thư viện như Moment.js nếu cần
  var parts = inputDate.split('-');
  return parts[2] + '/' + parts[1] + '/' + parts[0];
}






/*=============== SHOW SCROLL UP ===============*/ 
const scrollUp = () => {
    const scrollUp = document.getElementById('scroll-up');
    // When the scroll is higher than 350 viewport height, add the show-scroll class to the a tag with the scrollup class
    window.scrollY >= 350 ? scrollUp.classList.add('show-scroll') : scrollUp.classList.remove('show-scroll');
  };
  
  window.addEventListener('scroll', scrollUp);
  
  /*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
  const sections = document.querySelectorAll('section[id]');
  
  const scrollActive = () => {
    const scrollDown = window.scrollY;
  
    sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = current.offsetTop - 58;
      const sectionId = current.getAttribute('id');
      const sectionsClass = document.querySelector('.nav__menu a[href*=' + sectionId + ']');
  
      if (scrollDown > sectionTop && scrollDown <= sectionTop + sectionHeight) {
        sectionsClass.classList.add('active-link');
      } else {
        sectionsClass.classList.remove('active-link');
      }
    });
  };
  
  window.addEventListener('scroll', scrollActive);
  
// Select
const soPhongSelect = document.getElementById("soPhongSelect");
  const loaiGiuongSelect = document.getElementById("loaiGiuongSelect");
  const soNguoiLonSelect = document.getElementById("soNguoiLonSelect");
  const soEmBeSelect = document.getElementById("soEmBeSelect");
  const ketQuaTextArea = document.getElementById("ketQuaTextArea");

  // Hàm cập nhật textarea với thông tin đã chọn
  function updateKetQuaTextArea() {
    const selectedSoPhong = soPhongSelect.value;
    const selectedLoaiGiuong = loaiGiuongSelect.value;
    const selectedSoNguoiLon = soNguoiLonSelect.value;
    const selectedSoEmBe = soEmBeSelect.value;

    const ketQuaText = `Số phòng: ${selectedSoPhong}, Loại giường: ${selectedLoaiGiuong}, Số người lớn: ${selectedSoNguoiLon}, Số em bé: ${selectedSoEmBe}`;
    
    ketQuaTextArea.value = ketQuaText;
  }

  // Sử dụng sự kiện change để cập nhật textarea khi có thay đổi trong select box
  soPhongSelect.addEventListener("change", updateKetQuaTextArea);
  loaiGiuongSelect.addEventListener("change", updateKetQuaTextArea);
  soNguoiLonSelect.addEventListener("change", updateKetQuaTextArea);
  soEmBeSelect.addEventListener("change", updateKetQuaTextArea);

  // Gọi hàm cập nhật ban đầu
  updateKetQuaTextArea();
