(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    var alertTimeout;

    HT.changeall = () => {
        if ($('.activeAll').length) {

            $(document).on('click', '.activeAll', function (e) {
                e.preventDefault();

                let _this = $(this);
                let id = [];
                $('.checkBoxItem').each(function () {
                    let checkbox = $(this);
                    if (checkbox.prop('checked')) {
                        id.push(checkbox.attr('data-id'));
                    }
                });

                if (id.length == 0) {
                    alert('Vui lòng chọn ít nhất một mục');
                    return;
                }

                let option = {
                    'id': id,
                    'is_active': _this.attr('data-is_active'),
                    '_token': token
                };

                $.ajax({
                    type: 'POST',
                    url: 'vouchers/ajax/changeAllActiveVoucher',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.status) {
                            id.forEach(function (itemId) {
                                let switchInput = $('input[data-modelId="' + itemId + '"]');
                                let switcheryElement = switchInput[0].switchery;

                                if (res.newStatus == 1) {
                                    switchInput.prop('checked', true);
                                } else {
                                    switchInput.prop('checked', false);
                                }

                                switchInput.attr('data-model', res.newStatus);

                                switcheryElement.setPosition();
                            });
                            showAlert('Cập nhật trạng thái '+res.updatedCount+' voucher thành công!', 'success');
                        } else {
                            alert('Cập nhật thất bại: ' + res.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 403) {
                            alert('Bạn không có quyền thực hiện hành động này');
                        } else if (xhr.status === 400) {
                            alert('ID không hợp lệ');
                        } else {
                            alert('Có lỗi xảy ra, vui lòng thử lại');
                        }
                    }
                });

            });
        }
    }

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
        HT.changeall();
    });

})(jQuery);
