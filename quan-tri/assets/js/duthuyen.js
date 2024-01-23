function displayImage() {
    var input = document.getElementById('thumbnailInput');
    var preview = document.getElementById('thumbnailPreview');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
    }
}
function displayImages() {
    var input = document.getElementById('thumbnailsInput');
    var imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = '';

    if (input.files && input.files.length > 0) {
        for (var i = 0; i < input.files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.width = 100;
                imagePreview.appendChild(img);
            };
            reader.readAsDataURL(input.files[i]);
        }
    }
}
function togglePassword() {
    var passwordField = document.getElementById("yourPassword");
    var passwordToggle = document.getElementById("togglePasswordIcon");

    // Kiểm tra xem trường passwordVisible đã được định nghĩa chưa
    if (typeof passwordVisible === "undefined") {
      passwordVisible = false; // Nếu chưa, mặc định là false
    }

    // Thay đổi kiểu của trường nhập liệu giữa "password" và "text"
    if (passwordVisible) {
      passwordField.type = "password";
      passwordToggle.classList.remove("ri-eye-off-line");
      passwordToggle.classList.add("ri-eye-line");
    } else {
      passwordField.type = "text";
      passwordToggle.classList.remove("ri-eye-line");
      passwordToggle.classList.add("ri-eye-off-line");
    }

    // Đảo ngược giá trị của passwordVisible
    passwordVisible = !passwordVisible;
  }