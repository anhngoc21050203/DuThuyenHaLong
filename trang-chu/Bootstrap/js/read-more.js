$(document).ready(function () {
  $(".read-more-toggle").click(function () {
    var content = $(this).prev(".read-more-content");
    content.toggleClass("expanded");

    if (content.hasClass("expanded")) {
      content.css("max-height", content[0].scrollHeight + "px");
      $(this).text("Thu gọn");
    } else {
      content.css("max-height", "100px");
      $(this).text("Đọc thêm");
    }
  });
});
function toggleContent(contentId, arrowDownId, arrowUpId) {
  var content = document.getElementById(contentId);
  var arrowDown = document.getElementById(arrowDownId);
  var arrowUp = document.getElementById(arrowUpId);

  if (content.style.display === "none") {
      content.style.display = "block";
      arrowDown.style.display = "none";
      arrowUp.style.display = "inline";
  } else {
      content.style.display = "none";
      arrowDown.style.display = "inline";
      arrowUp.style.display = "none";
  }
}
function toggleContent_d(contentId) {
var content = document.getElementById(contentId);

if (content) {
  event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

  // Kiểm tra cả thuộc tính style và thuộc tính computedStyle để đảm bảo tính nhất quán
  var isHidden = content.style.display === 'none' || window.getComputedStyle(content).display === 'none';

  // Thay đổi trạng thái hiển thị
  content.style.display = isHidden ? 'block' : 'none';
}
}
