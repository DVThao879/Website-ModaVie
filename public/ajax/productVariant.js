jQuery(document).ready(function () {
    //Thêm biến thể
    jQuery('#add-variant-btn').on('click', function () {
        var currentRows = jQuery('#variants-container .form-variant');
        var newIndex = 0;

        // Tìm chỉ số mới không trùng từ thuộc tính data-index
        if (currentRows.length > 0) {
            var existingIndexes = currentRows.map(function () {
                return parseInt(jQuery(this).attr('data-index'));
            }).get();
            newIndex = Math.max.apply(Math, existingIndexes) + 1;
        }

        // Tạo HTML cho biến thể mới
        var newVariantRow = `
        <tr class="form-variant" id="variant-${newIndex}" data-index="${newIndex}">
            <td>
                <select name="variants[${newIndex}][size_id]" class="form-control" required>
                    <option value="">Chọn size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="variants[${newIndex}][color_id]" class="form-control" required>
                    <option value="">Chọn màu</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="variants[${newIndex}][quantity]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variants[${newIndex}][price]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variants[${newIndex}][price_sale]" class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger remove-variant-btn">Xóa</button>
            </td>
        </tr>
        `;

        // Thêm hàng mới vào container
        jQuery('#variants-container').append(newVariantRow);
    });

    // Xóa biến thể
    jQuery(document).on('click', '.remove-variant-btn', function () {
        if (jQuery('.form-variant').length > 1) {
            jQuery(this).closest('.form-variant').remove(); // Xóa hàng hiện tại
        } else {
            alert('Bạn cần ít nhất một biến thể');
        }
    });

    // Abum ảnh
    jQuery('#gallery').on('change', function () {
        var files = this.files;
        var previewContainer = jQuery('#image-preview');
        previewContainer.html('');

        if (files) {
            jQuery.each(files, function (index, file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var imageCol = jQuery('<div class="col-md-2 mb-3"></div>');
                    var imageElement = jQuery('<img class="img-thumbnail" style="width:100%;">');
                    imageElement.attr('src', e.target.result);
                    imageCol.append(imageElement);
                    previewContainer.append(imageCol);
                }
                reader.readAsDataURL(file);
            });
        }
    });

    // Ảnh đại diện
    jQuery('#img-preview').on('click', function () {
        jQuery('#img_thumb').click();
    });

    // Hiển thị hình ảnh đã chọn
    jQuery('#img_thumb').on('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                jQuery('#img-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

});