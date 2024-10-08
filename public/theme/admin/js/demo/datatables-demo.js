// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    stateSave: true,
    columnDefs: [
      { orderable: false, targets: 0 } // Vô hiệu hóa sắp xếp cho cột đầu tiên (checkbox)
    ],

    // Sự kiện khi DataTable được vẽ lại (ví dụ khi phân trang)
    drawCallback: function () {
      // Lấy tất cả các phần tử checkbox có class .js-switch
      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

      // Khởi tạo Switchery cho từng checkbox
      elems.forEach(function (html) {
        // Kiểm tra nếu Switchery chưa được khởi tạo
        if (!html.switchery) {
          html.switchery = new Switchery(html, { color: '#1AB394' });
        }
      });
      $('.checkBoxItem').prop('checked', false);
      $('#checkAllTable').prop('checked', false);
      $('tbody tr').removeClass('active-check');
    }
  });
});
