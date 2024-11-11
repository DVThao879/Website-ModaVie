// Call the dataTables jQuery plugin
$(document).ready(function () {
  var disableSort = $('#dataTable').data('disable-sort');
  $('#dataTable').DataTable({
    lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    stateSave: true,
    columnDefs: disableSort ? [] : [{ orderable: false, targets: 0 }],
    language: {
      "sProcessing": "Đang xử lý...",
      "sLengthMenu": "Hiển thị _MENU_ mục",
      "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
      "sInfo": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
      "sInfoEmpty": "Hiển thị 0 đến 0 của 0 mục",
      "sInfoFiltered": "(được lọc từ _MAX_ mục)",
      "sInfoPostFix": "",
      "sSearch": "Tìm kiếm:",
      "sUrl": "",
      "oPaginate": {
        "sFirst": "Đầu",
        "sPrevious": "Trước",
        "sNext": "Tiếp",
        "sLast": "Cuối"
      }
    },

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
