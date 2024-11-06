(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    var alertTimeout;

    HT.changeStt = () => {

        //ket hop swk de thay doi tt tai khoan
        if ($('.active').length) {
            $(document).on('change', '.active', function () {
                let _this = $(this)

                let title = _this.attr('data-title');

                let option = {
                    'id': _this.attr('data-modelId'),
                    'is_active': _this.attr('data-model'),
                    '_token': token
                }

                $.ajax({
                    type: 'POST',
                    url: 'categories/ajax/changeActiveCategory', // URL của máy chủ xử lý yêu cầu
                    data: option, // Dữ liệu gửi đến máy chủ
                    dataType: 'json', // Loại dữ liệu nhận lại từ máy chủ
                    success: function (res) {
                        if (res.status) {
                            // Cập nhật lại data-model
                            _this.attr('data-model', res.newStatus);
                            alert('Cập nhật thành công!');
                            showAlert('Thay đổi trạng thái của: ' + title + ' thành công!', 'success');
                        } else {
                            // In ra thông báo lỗi vào console
                            console.error('Cập nhật thất bại: ' + res.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                        alert('Đã xảy ra lỗi: ' + message);
                        console.error('Error:', error);
                        console.error('XHR:', xhr);
                        console.error('Status:', xhr.status);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status Description:', status)
                    }
                });

            });
        }
    };

    function showAlert(message, type) {
        let alertContainer = $('#alert-container');

        if (alertTimeout) {
            clearTimeout(alertTimeout);
        }

        alertContainer.removeClass('d-none alert-success alert-danger');
        alertContainer.addClass('alert-' + type);
        alertContainer.html(message);

        alertTimeout = setTimeout(function () {
            alertContainer.addClass('d-none');
        }, 5000);
    }

    $(document).ready(function () {
        HT.changeStt();
    });

})(jQuery);
