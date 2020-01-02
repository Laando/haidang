function renderFilePath(date_str) {
    var path = '';
    var t_stamp = date_str.replace(/[^0-9\.]+/g, "");
    var n_date = new Date(t_stamp * 1);
    path = n_date.getFullYear() + '/' + (n_date.getMonth() + 1) + '/' + n_date.getDate();
    return path;
}
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function formReset() {
    $('form').each(function (index, ele) {
        if ($(this).attr('data-noreset') !== 'true') {// nếu không reset
            $(ele)[0].reset();
            $(ele).find('[name="Id"]').val('');
            if ($(ele).hasClass('select')) {
                $(ele).val('').change();
                $(ele).change();
            }
        }
    });
    if ($('.summernote').length > 0) {
        $('.summernote').code('');
    }
}
function parseDate(input, format, hastime = false) {
    format = format || 'yyyy-mm-dd';
    var parts = input.match(/(\d+)/g),
        i = 0, fmt = {};
    if (hastime) {
        format.replace(/(yyyy|dd|mm|hh|ii)/g, function (part) { fmt[part] = i++; });
        return new Date(parts[fmt['yyyy']], parts[fmt['mm']] - 1, parts[fmt['dd']], parts[fmt['hh']], parts[fmt['ii']]);
    } else {
        format.replace(/(yyyy|dd|mm)/g, function (part) { fmt[part] = i++; });
        return new Date(parts[fmt['yyyy']], parts[fmt['mm']] - 1, parts[fmt['dd']]);
    }
}
function dateToString(date, char = '/', type = 1) {
    try {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        if (day < 10) day = '0' + day;
        if (month < 10) month = '0' + month;
        if (type === 1 || type === 4) {
            if (type === 1) {
                return day + char + month + char + year;
            } else {
                return day + char + month + char + year + ' ' + (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes());// dd/mm/yyyy hh:ii
            }

        } else {
            if (type === 3) {
                return year + char + month + char + day + ' ' + (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes());// UTC FORMAT
            } else {
                return year + char + month + char + day;// UTC FORMAT
            }

        }
    } catch (ex) {
        Message.ShowErrorMessage("Dữ liệu ngày tháng không đúng !");
    }
}
function days_between(date1, date2) {
    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24;
    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();
    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);
    // Convert back to days and return
    return Math.round(difference_ms / ONE_DAY);
}

function removeAllAttributes(nodes, except = { 'class': true, 'name': true, 'id': true }) {
    $.each(nodes, function (index, node) {
        var attributes = $.map(this.attributes, function (node) {
            return node.name;
        });
        // now use jQuery to remove the attributes
        var img = $(this);
        $.each(attributes, function (i, item) {
            if (typeof except[item] === 'undefined') {
                $(node).removeAttr(item);
            }
        });
    });
}
function formatZero(str) {
    var arr;
    str = str + '';
    if (str === '0' || str === '0,00' || str === '0.00') return '';
    if (str.indexOf(',00') !== -1) {
        arr = str.split(',');
        str = arr[0];
    }
    if (str.indexOf('.00') !== -1) {
        arr = str.split('.');
        str = arr[0];
    }
    if (str == 'null') {
        str = '';
    }
    return str;
}
function formatThousand(num) {
    num = num + '';
    var parts = num.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
function shortenString(string, numword = 50, endchar = '...') {
    //trim the string to the maximum length
    if (string !== null) {
        var trimmedString = string.substr(0, numword);
        //re-trim if we are in the middle of a word
        if (string.length > numword) {
            trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")));
            trimmedString = trimmedString + " " + endchar;
        }
        return trimmedString;
    }
    return '';
}
function uploadFile(input, base_url, files = '') {
    let $input = $(input);
    if (files === '') {
        files = input[0].files;
    }
    if (files.length > 0) {
        let allowedExtensions = ["png", "jpg", "jpeg"];
        let fileSize = 0;
        for (var i = 0; i < files.length; i++) {
            let file = files[i];
            let filename = file.name;
            if (filename === undefined || filename === null || filename.length === 0) {
                Message.ShowErrorMessage(TextProvider.Get("CMS.Validation.Format.Invalid").replace("{0}", TextProvider.Get("Manage.File.Name")));
                $input.val('');
                return false;
            }
            let filenameSplit = filename.split('.');
            let extension = filenameSplit[filenameSplit.length - 1].toLowerCase();
            if (allowedExtensions.indexOf(extension) === -1) {
                Message.ShowErrorMessage(TextProvider.Get("CMS.Validation.Format.NotAllowed").replace("{0}", TextProvider.Get("Manage.File.FileType")));
                $input.val('');
                return;
            }
            fileSize += file.size;
            //Max file size should be 10MB
            if (fileSize / 1048576 > 10) {
                Message.ShowErrorMessage(TextProvider.Get("Manage.File.TenMBAllowed"));
                $input.val('');
                return;
            }
        }
    }
    let data = new FormData($input.parents("form")[0]);
    //data.append("Path", gCurrentFolderPath);
    AjaxProvider.PostFormData({
        url: base_url + "/uploadFile",
        data: data,
        success: function (response) {
            if (response.status === 200) {
                Message.ShowSuccessMessage(response.message);
            } else {
                Message.ShowErrorMessage(response.message);
            }
        }
    });
}
function uploadFiles(url, files) {
    if (files.length > 0) {
        let allowedExtensions = ["png", "jpg", "jpeg"];
        let fileSize = 0;
        for (var i = 0; i < files.length; i++) {
            let file = files[i];
            let filename = file.name;
            if (filename === undefined || filename === null || filename.length === 0) {
                Message.ShowErrorMessage(TextProvider.Get("CMS.Validation.Format.Invalid").replace("{0}", TextProvider.Get("Manage.File.Name")));
                $input.val('');
                return false;
            }
            let filenameSplit = filename.split('.');
            let extension = filenameSplit[filenameSplit.length - 1].toLowerCase();
            if (allowedExtensions.indexOf(extension) === -1) {
                Message.ShowErrorMessage(TextProvider.Get("CMS.Validation.Format.NotAllowed").replace("{0}", TextProvider.Get("Manage.File.FileType")));
                $input.val('');
                return;
            }
            fileSize += file.size;
            //Max file size should be 10MB
            if (fileSize / 1048576 > 10) {
                Message.ShowErrorMessage(TextProvider.Get("Manage.File.TenMBAllowed"));
                $input.val('');
                return;
            }
        }
    }
    var form = $('<form></form>');
    form.append($('<input type="file" name="Files"/>'));
    form.find('input[name="Files"]')[0].files = files;
    var token = '';
    $('form').each(function (index, form) {
        var hasToken = $(form).find('input[name="__RequestVerificationToken"]');
        if (hasToken.length > 0) {
            token = $(hasToken).val();
            //form.append($(hasToken).clone());
        }
    });
    var data = new FormData(form[0]);
    data.append('__RequestVerificationToken', token);
    AjaxProvider.PostFormData({
        url: url + "/uploadFiles",
        data: data,
        async: false,
        success: function (response) {
            if (response.status === 200) {
                Message.ShowSuccessMessage(response.message);
            } else {
                Message.ShowErrorMessage(response.message);
            }
        }
    });
}
function setObjToField(obj, prefix = '') {
    var list_prop = Object.getOwnPropertyNames(obj);
    $.each(list_prop, function (index, item) {
        if ($('#' + prefix + item).attr('type') != 'file') {
            $('#' + prefix + item).val(obj[item]);
            if ($('#' + prefix + item).attr('type') === 'hidden') {
                $('#' + prefix + item).parent().find('.text_box[data-val="' + obj[item] + '"]').siblings()
                    .removeClass('active');
                $('#' + prefix + item).parent().find('.text_box[data-val="' + obj[item] + '"]').addClass('active');
            }
            if ($('#' + prefix + item).hasClass('datetime')) {
                var t_stamp = $('#' + prefix + item).val().replace(/[^0-9\.]+/g, "");
                var n_date = new Date(t_stamp * 1);
                var date_string = dateToString(n_date);
                $('#' + prefix + item).val(date_string);
            }
            if ($('#' + prefix + item).hasClass('select')) {
                $('#' + prefix + item).change();
            }
            if ($('#' + prefix + item).hasClass('summernote')) {
                $('#' + prefix + item).code($('<div />').html(obj[item]).text());
            }
        }
    });
}
function setObjToFieldV1(obj, $parentNode, prefix = '') {
    var list_prop = Object.getOwnPropertyNames(obj);
    $.each(list_prop, function (index, item) {
        if ($parentNode.find(prefix + item).attr('type') != 'file') {
            let html_item = $parentNode.find(prefix + item)[0];
            if (html_item !== undefined && (html_item.tagName === 'P' || html_item.tagName === 'SPAN')) {
                $parentNode.find(prefix + item).text(obj[item]);
                if ($parentNode.find(prefix + item).hasClass('datetime')) {
                    var date_string;
                    if (obj[item] === null) {
                        date_string = '';
                    } else {
                        var t_stamp = $parentNode.find(prefix + item).text().replace(/[^0-9\.]+/g, "");
                        var n_date = new Date(t_stamp * 1);
                        date_string = dateToString(n_date);
                    }
                    $parentNode.find(prefix + item).text(date_string);
                }
                if ($parentNode.find(prefix + item).hasClass('input_money')) {
                    $parentNode.find(prefix + item).text(formatThousand(obj[item]));
                }
            } else {
                $parentNode.find(prefix + item).val(obj[item]);
                if ($parentNode.find(prefix + item).attr('type') === 'hidden') {
                    $parentNode.find(prefix + item).parent().find('.text_box[data-val="' + obj[item] + '"]').siblings()
                        .removeClass('active');
                    $parentNode.find(prefix + item).parent().find('.text_box[data-val="' + obj[item] + '"]').addClass('active');
                }
                if ($parentNode.find(prefix + item).hasClass('datetime')) {
                    var date_string;
                    if (obj[item] === null) {
                        date_string = '';
                    } else {
                        var t_stamp = $parentNode.find(prefix + item).val().replace(/[^0-9\.]+/g, "");
                        var n_date = new Date(t_stamp * 1);
                        date_string = dateToString(n_date);
                    }
                    $parentNode.find(prefix + item).val(date_string);
                }
                if ($parentNode.find(prefix + item).hasClass('select')) {
                    if ($parentNode.find(prefix + item).val() === '' ||
                        typeof $parentNode.find(prefix + item) === 'undefined') {
                        $parentNode.find(prefix + item).val('');
                    }
                    $parentNode.find(prefix + item).change();
                }
                if ($parentNode.find(prefix + item).hasClass('summernote')) {
                    $parentNode.find(prefix + item).code($('<div />').html(obj[item]).text());
                }
                if ($parentNode.find(prefix + item).hasClass('input_money')) {
                    $parentNode.find(prefix + item).val(formatThousand(obj[item]));
                }
                if (typeof $parentNode.find(prefix + item)[0] !== 'undefined') {
                    if ($parentNode.find(prefix + item)[0].tagName === 'TD') {
                        if ($parentNode.find(prefix + item).hasClass('input_money')) {
                            $parentNode.find(prefix + item).text(formatThousand(obj[item]));
                        } else {
                            $parentNode.find(prefix + item).text(obj[item]);
                        }
                    }
                }

                /////////////// focused class
                if (!(obj[item] === '' || obj[item] === null)) {
                    $parentNode.find(prefix + item).closest('.item').addClass('focused');
                }
            }
        }
    });
}
function BindingChildTableToModel($tableBodyNode, $errorNode, ExceptValidation = [], paramName = 'data-field', checkDatepickerName = 'is_datepicker', inputMoneyClassName = 'money_input') {
    // init and valid child form
    var row_children = $tableBodyNode.find('tr');
    var table_header = $tableBodyNode.closest('table').find('thead');
    var sendObj = {};
    var ErrorList = [];
    $.each(row_children,
        function (index, row) {
            $(row).find('td').each(function (i_td, col) {
                var input_children = $(col).find('[' + paramName + ']');
                $.each(input_children,
                    function (i, item) {
                        //                        if ($(item).attr(paramName) === 'Profile_ProfileID') {
                        //                            console.log($(item).val());
                        //                        }
                        if (item.tagName === "SELECT") {
                            // valid
                            var not_in_except = true;
                            var class_text = $(item).attr(paramName);

                            $.each(ExceptValidation,
                                function (i_except, except) {
                                    if (class_text.indexOf(except) !== -1) not_in_except = false;
                                });
                            if ($(item).val().trim() === '' && not_in_except) {
                                var index_td = $(row).find('td').index(col);
                                var label_col = $(table_header).find('th')[index_td];
                                var error = {
                                    element: $(item),
                                    message: 'Cần chọn ' + $(label_col).text() + ' ở dòng ' + (index + 1)
                                };
                                var is_exist = false;
                                $.each(ErrorList,
                                    function (i_e, eerror) {
                                        if (eerror.message === error.message) {
                                            is_exist = true;
                                        }
                                    });
                                if (is_exist === false) {
                                    ErrorList.push(error);
                                }
                            }
                            /////
                            var classList = $(item).attr(paramName);
                            var className = classList;
                            if (className !== '') {
                                if (!sendObj.hasOwnProperty(className)) {
                                    sendObj[className] = [];
                                }
                                if ($(item).hasClass(checkDatepickerName)) {
                                    sendObj[className].push(dateToString(parseDate($(item).val(), 'dd/mm/yyyy'), '-', 2));
                                } else {
                                    sendObj[className].push($(item).val());
                                }
                            }
                        }
                        if (item.tagName === "INPUT") {
                            // valid
                            var not_in_except = true;
                            var class_text = $(item).attr(paramName);
                            var isFile = $(item).attr('type') === 'file';
                            $.each(ExceptValidation,
                                function (i_except, except) {
                                    if (class_text.indexOf(except) !== -1) not_in_except = false;
                                });

                            if ($(item).val().trim() === '' && not_in_except) {
                                var index_td = $(row).find('td').index(col);
                                var label_col = $(table_header).find('th')[index_td];
                                var error = {
                                    element: $(item),
                                    message: 'Cần chọn ' + $(label_col).text() + ' ở dòng ' + (index + 1)
                                };
                                var is_exist = false;
                                $.each(ErrorList,
                                    function (i_e, eerror) {
                                        if (eerror.message === error.message) {
                                            is_exist = true;
                                        }
                                    });
                                if (is_exist === false) {
                                    ErrorList.push(error);
                                }
                            }
                            /////
                            var classList = $(item).attr(paramName);
                            var className = classList;
                            if (className !== '') {
                                if (!sendObj.hasOwnProperty(className)) {
                                    sendObj[className] = [];
                                }
                                if ($(item).hasClass(checkDatepickerName)) {
                                    if ($(item).val() !== '') {
                                        sendObj[className].push(dateToString(parseDate($(item).val(), 'dd/mm/yyyy'), '-', 2));
                                    }

                                } else {
                                    if ($(item).hasClass(inputMoneyClassName)) {
                                        var value = $(item).val().replace(/[,]+/g, "");
                                        sendObj[className].push(value);
                                    } else {
                                        if (!isFile) {
                                            sendObj[className].push($(item).val());
                                        } else {
                                            files = $(item)[0].files;
                                            sendObj[className].push(files[0]);
                                        }

                                    }
                                }
                            }

                        }
                        if (item.tagName === "P") {
                            // valid
                            var not_in_except = true;
                            var class_text = $(item).attr(paramName);

                            $.each(ExceptValidation,
                                function (i_except, except) {
                                    if (class_text.indexOf(except) !== -1) not_in_except = false;
                                });
                            var count_active = $(item).parent().find('.active').length;
                            if (count_active === 0 && not_in_except) {
                                var index_td = $(row).find('td').index(col);
                                var label_col = $(table_header).find('th')[index_td];
                                var error = {
                                    element: $(item),
                                    message: 'Cần chọn ' + $(label_col).text() + ' ở dòng ' + (index + 1)
                                };
                                var is_exist = false;
                                $.each(ErrorList,
                                    function (i_e, eerror) {
                                        if (eerror.message === error.message) {
                                            is_exist = true;
                                        }
                                    });
                                if (is_exist === false) {
                                    ErrorList.push(error);
                                }
                            }
                            ////////// radio button has active class
                            if ($(item).hasClass('active')) {
                                var classList = $(item).attr(paramName);
                                var className = classList;
                            }
                        }
                        if (item.tagName === "DIV") {
                            // valid
                            var not_in_except = true;
                            var class_text = $(item).attr(paramName);
                            var class_check = $(item).hasClass('check-td');
                            if (class_check) {
                                $.each(ExceptValidation,
                                    function (i_except, except) {
                                        if (class_text.indexOf(except) !== -1) not_in_except = false;
                                    });
                                var isActive = $(item).hasClass('active');
                                if (not_in_except) {
                                    var index_td = $(row).find('td').index(col);
                                    var label_col = $(table_header).find('th')[index_td];
                                    var error = {
                                        element: $(item),
                                        message: 'Cần chọn ' + $(label_col).text() + ' ở dòng ' + (index + 1)
                                    };
                                    var is_exist = false;
                                    $.each(ErrorList,
                                        function (i_e, eerror) {
                                            if (eerror.message === error.message) {
                                                is_exist = true;
                                            }
                                        });
                                    if (is_exist === false) {
                                        ErrorList.push(error);
                                    }
                                }
                                ////////// radio button has active class
                                if (class_text !== '') {
                                    if (!sendObj.hasOwnProperty(class_text)) {
                                        sendObj[class_text] = [];
                                    }
                                    sendObj[class_text].push(isActive);
                                }
                            }
                        }
                    });
            });
        });
    if (ErrorList.length > 0) {
        $errorNode.html('');
        $.each(ErrorList,
            function (index, error) {
                $errorNode.append('<div class="error">' + error.message + '</div>');
            });
        sendObj = false;
    } else {
        $errorNode.html('');

    }
    return sendObj;
    ////////////////////////////
}
function ValidFile(node) {
    let $input = $(node);
    let files = '';
    if (files === '') {
        files = node.files;
    }
    if (files.length > 0) {
        let allowedExtensions = ["png", "jpg", "jpeg"];
        let fileSize = 0;
        for (var i = 0; i < files.length; i++) {
            let file = files[i];
            let filename = file.name;
            if (filename === undefined || filename === null || filename.length === 0) {
                Message.ShowErrorMessage(TextProvider.Get("CMS.Validation.Format.Invalid").replace("{0}", TextProvider.Get("Manage.File.Name")));
                $input.val('');
                return false;
            }
            let filenameSplit = filename.split('.');
            let extension = filenameSplit[filenameSplit.length - 1].toLowerCase();
            if (allowedExtensions.indexOf(extension) === -1) {
                Message.ShowErrorMessage(TextProvider.Get("CMS.Validation.Format.NotAllowed").replace("{0}", TextProvider.Get("Manage.File.FileType")));
                $input.val('');
                return false;
            }
            fileSize += file.size;
            //Max file size should be 10MB
            if (fileSize / 1048576 > 10) {
                Message.ShowErrorMessage(TextProvider.Get("Manage.File.TenMBAllowed"));
                $input.val('');
                return false;
            }
        }
        return true;
    }
    return false;
}
var objectToFormData = function (obj, form, namespace) {
    var fd = form || new FormData();
    var formKey;
    for (var property in obj) {
        if (obj.hasOwnProperty(property)) {

            if (namespace) {
                formKey = namespace + '[' + property + ']';
            } else {
                formKey = property;
            }

            // if the property is an object, but not a File,
            // use recursivity.
            if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {

                objectToFormData(obj[property], fd, property);

            } else {

                // if it's a string or a File object
                fd.append(formKey, obj[property]);
            }

        }
    }
    return fd;
};
/*
 * string formID : name of form selector
 * array nameInputs : input name or id
 * array nameEnabledInputs selector enabled : array of name input selector enabled
 * array nameHideInputs selector disabled : array of name input selector disabled
 * array nameShowInputs selector enabled : array of name input selector enabled
 */
function setPropInputForm(formID, nameInputs, propName, value = true, isClear = false) {

    $.each(nameInputs, function (index, inputName) {
        let inputByName = $(formID).find('[name="' + inputName + '"]').prop(propName, value);
        let inputById = $(formID).find('#' + inputName).prop(propName, value);
        if (inputByName.data('select2')) {
            inputByName.change();
        }
        if (inputById.data('select2')) {
            inputById.change();
        }
        if (isClear) {
            if (inputById.data('select2')) {
                inputById.empty().change();
            }
            inputById.val('');
            inputByName.val('');
            inputById.text('');
            inputByName.text('');
        }
    });
}
function setVisibleInputForm(formID, nameInputs, propName, show = true) {
    $.each(nameInputs, function (index, inputName) {
        if (show) {
            let inputByName = $(formID).find('[name="' + inputName + '"]').show();
            let inputById = $(formID).find('#' + inputName).show();
        } else {
            let inputByName = $(formID).find('[name="' + inputName + '"]').hide();
            let inputById = $(formID).find('#' + inputName).hide();
        }
    });
}
/*
 * not finished
 * 0 : disabled all
 * 1 :  create
 * 2 :  edit
 * 3 :  view
 */
var slug = function (str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
    str = change_alias(str);
    // remove accents, swap ñ for n, etc
    var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆĞÍÌÎÏİŇÑÓÖÒÔÕØŘŔŠŞŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇğíìîïıňñóöòôõøðřŕšşťúůüùûýÿžþÞĐđßÆa·/,:;";
    var to = "AAAAAACCCDEEEEEEEEGIIIIINNOOOOOORRSSTUUUUUYYZaaaaaacccdeeeeeeeegiiiiinnooooooorrsstuuuuuyyzbBDdBAa-----";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 _-]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
};
function change_alias(alias) {
    var str = alias;
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|`|-|{|}|\||\\/g, " ");
    str = str.replace(/ + /g, " ");
    str = str.trim();
    return str;
}
function slugify(file) {
    let filename = file.split('.').slice(0, -1).join('.');
    let fileext = file.split('.').pop().toLowerCase();
    return slug(filename) + '.' + fileext;
}
var Helper = {

}
function trim (s, c) {
    if (c === "]") c = "\\]";
    if (c === "\\") c = "\\\\";
    return s.replace(new RegExp(
        "^[" + c + "]+|[" + c + "]+$", "g"
    ), "");
}
function TourResult() {
    var $form = $('#TourResult');
    var tour_id = $form.find('#TourId').val();
    var model = FormProvider.BindToModel($form);
    if(typeof startdates !== 'undefined'){
        model.tour_startdate_id  = GetStartDateByDate(model.tour_startdate, tour_id , startdates);
    }
    $.ajax({
        url:'http://'+window.location.host+'/home/GetTourResult',
        type: "POST",
        data: model ,
        success: function(data, textStatus, jqXHR) {
            if(data!=='fail') {
                data = JSON.parse(data);
                $('#tour-result').find('#tbody-result').html('');
                let total = 0 ;
                $.each(data,function(index,item){
                    total += item[4] ;
                    $('#tour-result').find('#tbody-result').append(
                        `<tr>
                            <td class="text-left">${formatZero(item[0])}</td>
                            <td>${formatZero(item[1])}</td>
                            <td>${formatZero(item[2])}</td>
                            <td>${numbertomoney(item[3]+'')}</td>
                            <td>${numbertomoney(item[4]+'')}</td>
                         </tr>`
                    );
                });
                $('#tour-result').find('#tbody-result').append(
                    `<tr>
                            <td class="text-center font-weight-bold">Tổng cộng</td>
                            <td colspan="3" class="font-weight-bold"></td>
                            <td class="font-weight-bold">${numbertomoney(total+'')}</td>
                         </tr>`
                );
            } else {
                notify('Có lỗi vui lòng thử lại sau !');
            }
        }
    });
}
function GetStartDateByDate(string ,tour_id , startdateList){
    let current_date  =  moment(string, "DD/MM/YYYY").toDate();
    let startdate_id = null;
    $.each(startdateList,function(index,obj){
        if(( current_date.getYear() === obj.date.getYear() &&
                current_date.getMonth() === obj.date.getMonth() &&
                current_date.getDate() === obj.date.getDate() &&
                tour_id == obj.tour_id
            )){
            startdate_id = obj.startdate_id ;
            return startdate_id;
        }
    })
    return startdate_id ;
}
function BookingTour(button ){
    let $form  = $(button).closest('form');
    let model  = FormProvider.BindToModel($form);
    model.tour_startdate_id = GetStartDateByDate(model.tour_startdate, model.tour_id , startdates);
    $.ajax({
        url:'http://'+window.location.host+'/home/BookingTour',
        type: "POST",
        data: model ,
        success: function(data, textStatus, jqXHR) {
            if(data==='ok') {
                if(isAuthenticated){
                    location = '/booking';
                } else {
                    location = '/login?backUrl=/booking';
                }
            } else {
                toastr.error('Có lỗi vui lòng thử lại sau !','Có lỗi')
            }
        },
        error : function(data,b,c) {
            let errors =Object.values( data.responseJSON).join('<br>');
            toastr.error(errors,'Có lỗi')
        }
    });
}
function loadInputMask(){
    $(".moneymask").inputmask("decimal",{
        removeMaskOnSubmit :true,
        clearMaskOnLostFocus: true,
        autoUnmask :true,
        groupSeparator: ",",
        digits: 0,
        autoGroup: true,
        suffix: ' đ'
    });
    $('.percentmask').inputmask("9[99]%",{
        removeMaskOnSubmit :true
    });
    $('.modal').on('change','select',function(){
        var checkinput = $(this).parent().parent().find('.adding').last().find('input.price');
        if($(this).val()=='2'||$(this).val()=='5') {
            $(checkinput).removeClass('moneymask').addClass('percentmask').inputmask("9[99]%",{
                removeMaskOnSubmit :true,
            });
        } else {
            if($(checkinput).hasClass('percentmask')){
                $(checkinput).removeClass('percentmask').addClass('moneymask').inputmask("decimal",{
                    removeMaskOnSubmit :true,
                    clearMaskOnLostFocus: true,
                    autoUnmask :true,
                    groupSeparator: ",",
                    digits: 0,
                    autoGroup: true,
                    suffix: ' đ'
                });
            }
        }
    });
}
function CheckPromotionCode(button){
    let code  =  $('#PromotionCode').val();
    if(code !== ''){
        let token = _globalObj._token;
        $.ajax({
            url:'http://'+window.location.host+'/home/CheckPromotionCode',
            type: "POST",
            data: {code:code , _token : token} ,
            success: function(data, textStatus, jqXHR) {
                if(data==='ok') {
                    toastr.success('Mã giảm giá đã được áp dụng cho đơn hàng !');
                } else {
                    toastr.error('Mã giảm giá không hợp lệ','Có lỗi');
                    $('#PromotionCode').val('');
                }
            },
            error : function(data,b,c) {
                let errors =Object.values( data.responseJSON).join('<br>');
                toastr.error(errors,'Có lỗi')
            }
        });
    }
}
function ConfirmOrder() {
    let token = _globalObj._token;
    $.ajax({
        url:'http://'+window.location.host+'/home/ConfirmOrder',
        type: "POST",
        data : { _token : token},
        success: function(data, textStatus, jqXHR) {
            if(data==='ok') {
                $('#ConfigOrderModal').modal('hide');
                toastr.success('Xác nhận đơn hàng thành công ! Chúng tôi sẽ liên hệ lại với bạn !');
            } else {
                toastr.error('Có lỗi khi xác nhận đơn hàng !','Có lỗi');
            }
        },
        error : function(data,b,c) {
            let errors =Object.values( data.responseJSON).join('<br>');
            toastr.error(errors,'Có lỗi')
        }
    });
}
function AddRow(button , tbody_id) {
    let row  = $('#'+tbody_id).find('tr').last().clone();
    $('#'+tbody_id).append(row);
}
function removeAddingExtra(button){
    let tbody = $(button).closest('tbody');
    if(tbody.find('tr').length > 1){
        $(button).closest('tr').remove();
    } else {
        alert('Không thể xóa');
    }

}
function UpdateStarDate(button){
    var $form = $(button).closest('form');
    var model = FormProvider.BindToModel($form);
    model.tour_id = $('#TourId').val();
    model.startdate_id  = $(button).attr('data-id');
    $.ajax({
        url:'http://'+window.location.host+'/staff/UpdateStartDate',
        type: "POST",
        data: model ,
        success: function(data, textStatus, jqXHR) {
            if(data==='ok') {
                $('#StartDateModal').modal('hide');
                if(model.startdate_id){
                    alert('Tạo mới ngày khởi hành thành công !');
                } else {
                    alert('Cập nhật ngày khởi hành thành công !');
                }
                location.reload();
            } else {alert('Có lỗi');}
        }
    });
}
function DeleteStartDate(id) {
    var token = _globalObj._token;
    if(confirm("Bạn có chắc muốn xóa ?")){
        $.ajax({
            url:'http://'+window.location.host+'/staff/DeleteStartDate',
            type: "POST",
            data: { id : id , _token : token} ,
            success: function(data, textStatus, jqXHR) {
                if(data==='ok') {
                    alert('Xóa ngày khởi hành thành công !');
                    location.reload();
                } else {alert('Có lỗi');}
            }
        });
    }
}
function GetStartDate(id , callback) {
    var token = _globalObj._token;
    $.ajax({
        url:'http://'+window.location.host+'/staff/GetStartDate',
        type: "POST",
        data: { id : id , _token : token} ,
        success: function(data, textStatus, jqXHR) {
            if(data!=='fail') {
                let model  = JSON.parse(data);
                callback(model);
            } else {
                alert('Có lỗi');
            }
        }
    });
}
function InitStatdateModal(){
    $('#StartDateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        if(!button.hasOwnProperty('length')){
            return;
        }
        $('#StartDateModal').find('[name="startdate"]').datepicker('destroy');
        if(button.attr('data-id')){
            $('#StartDateModal').find('[name="startdate"]').datepicker({
                format: "dd/mm/yyyy",
                minView: "month",
                autoclose: false,
                language: 'vi',
                //multidate : true
            });
            $('#StartDateModal').find('[name="startdate"]').datepicker('update');
            GetStartDate(button.attr('data-id'),function(model){
                let tmp = model.addings.replace('\n','');
                model.addings = JSON.parse(tmp);
                let date = new Date(model.startdate);
                $('#StartdateID').val(model.id);
                $('#StartDateModal').find('[name="startdate"]').val(dateToString(date));
                $('#StartDateModal').find('[name="startdate"]').datepicker('setDate',date);
                $('#StartDateModal').find('[name="startdate_seat"]').val(model.seat);
                $('#StartDateModal').find('[name="startdate_traffic"]').val(model.traffic);
                $('#StartDateModal').find('[name="startdate_adult_price"]').val(model.adult_price);
                $('#StartDateModal').find('[name="startdate_baby_price"]').val(model.baby_price);
                $('#StartDateModal').find('[name="startdate_child_price"]').val(model.child_price);
                let clone_tr_root = $('#startdateTbody').find('tr').first().clone();
                $('#startdateTbody').find('tr').remove();
                $.each(model.addings,function(index,item){
                    let clone_tr = $(clone_tr_root).clone();
                    $(clone_tr).find('[name="adding_name[]"]').val(item.name);
                    $(clone_tr).find('[name="adding_price[]"]').val(item.price);
                    let required = item.required === 'true' ? true : false;
                    let has_seat = item.has_seat === 'true' ? true : false;
                    $(clone_tr).find('[name="adding_obj[]"]').val(item.obj);
                    $(clone_tr).find('[name="adding_required[]"]').prop('checked',required);
                    $(clone_tr).find('[name="adding_hasSeat[]"]').prop('checked',has_seat);
                    $('#startdateTbody').append(clone_tr);
                });
                InitMoneyMask($('#StartDateModal'));
            })
        } else {
            $('#StartdateID').val('');
            $('#StartDateModal').find('[name="startdate"]').datepicker({
                format: "dd/mm/yyyy",
                minView: "month",
                autoclose: false,
                language: 'vi',
                multidate : true
            });
            $('#StartDateModal').find('[name="startdate"]').datepicker('setDate',null);
            $('#StartDateModal').find('[name="startdate"]').datepicker('update');
            $('#StartDateModal').find('[name="startdate"]').val('');
            $('#StartDateModal').find('[name="startdate_seat"]').val('');
            $('#StartDateModal').find('[name="startdate_traffic"]').val('');
            $('#StartDateModal').find('[name="startdate_adult_price"]').val('');
            $('#StartDateModal').find('[name="startdate_baby_price"]').val('');
            $('#StartDateModal').find('[name="startdate_child_price"]').val('');
            $('#startdateTbody').find('tr').each(function(index , tr){
                if(index !== 0){
                    $(tr).remove();
                }
            });
            $('#StartDateModal').find('[name="adding_name[]"]').val('')
            $('#StartDateModal').find('[name="adding_price[]"]').val('')
            $('#StartDateModal').find('[name="adding_required[]"]').prop('checked',false);
            $('#StartDateModal').find('[name="adding_hasSeat[]"]').prop('checked',false);
            InitMoneyMask($('#StartDateModal'));
        }
        if(typeof doCalculateCart !== 'undefined') doCalculateCart();
        ////
    })
}
function GetMiscalculate(id , callback) {
    var token = _globalObj._token;
    $.ajax({
        url:'http://'+window.location.host+'/staff/GetMiscalculate',
        type: "POST",
        data: { startdate_id : id , _token : token} ,
        success: function(data, textStatus, jqXHR) {
            if(data!=='fail') {
                let model  = JSON.parse(data);
                callback(model);
            } else {
                alert('Có lỗi');
            }
        }
    });
}
function InitMiscalculateModal(){
    InitMoneyMask($('#MiscalculateModal'));
    $('#MiscalculateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        if(button.attr('data-id')){
            GetMiscalculate(button.attr('data-id'),function(model){
                $('#MiscalculateDetail').find('[name="startdate_id"]').val(button.attr('data-id'));
                console.log(model);
                if(model.length>0){
                    alert('1');
                }
            })
        }
    })
}
function InitMoneyMask($parent){
    $($parent).find('.moneymask').inputmask('decimal',{
        removeMaskOnSubmit :true,
        clearMaskOnLostFocus: true,
        autoUnmask :true,
        groupSeparator: ',',
        digits: 0,
        autoGroup: true,
    });
    $($parent).find('input').inputmask('decimal',{
        removeMaskOnSubmit :true,
        clearMaskOnLostFocus: true,
        autoUnmask :true,
        groupSeparator: ',',
        digits: 0,
        autoGroup: true,
    });
}
function GetAddings(element){
    let startdate_id = $(element).val();
    let token = _globalObj._token;
    let $form = $(element).closest('form');
    let adult  =  $form.find('[name="adult"]').val();
    let child  =  $form.find('[name="child"]').val();
    let baby  =  $form.find('[name="baby"]').val();
    let current_order_addings  = typeof order_addings !== 'undefined'? order_addings : null;
    $.ajax({
        url:'http://'+window.location.host+'/home/GetAddings',
        type: "GET",
        data: { id : startdate_id , _token : token} ,
        success: function(data, textStatus, jqXHR) {
            if(data!=='fail') {
                let addings = window['current_addings'] = JSON.parse(data);
                //process required
                let addings_required = addings.filter(x=>x.required === 'true' && (x.obj*1) <= 2);
                let addings_standard = addings.filter(x=>x.required === 'true' && (x.obj*1) > 2);
                $('#AddingStandard').html('<option value="" data-price="0">Mặc định</option>');
                if(addings_required.length > 0){
                    $('.addingrow.required').each(function(index , item){
                        if(index > 0 ){
                            $(item).remove();
                        } else {
                            $(item).show();
                        }
                    }) ;
                    $.each(addings_required , function(index , adding){
                        let clone_required_element  = $('.addingrow.required').first();
                        if(index !== 0 ) {
                            clone_required_element  = $('.addingrow.required').clone();
                        }
                        clone_required_element.find('.adding_name').text(adding.name);
                        if((adding.obj*1) <=2){
                            let total_person = 0;
                            if(adding.obj*1 === 0){
                                total_person = adult*1+child*1+baby*1 ;
                            }
                            if(adding.obj*1 === 1){
                                total_person = child ;
                            }
                            if(adding.obj*1 === 2){
                                total_person = baby ;
                            }
                            clone_required_element.find('[name="amount[]"]').val(total_person);
                        }
                        // else {
                        //
                        //     $('#AddingStandard').append(`<option value="${ adding.obj}" data-price="${ adding.price }">${ adding.name }</option>`)
                        // }
                        clone_required_element.find('.adding-price').val(adding.price.replace(',',''));
                        clone_required_element.find('.addingobj').val(adding.obj);
                        clone_required_element.find('[name="addingtype[]"]').val(adding.name);
                    });


                } else {
                    $('.addingrow.required').hide();
                }
                // tiểu chuẩn
                if(addings_standard.length > 0){
                    let adding = addings_standard[0];
                    $('#AddingStandard').append(`<option value="${ adding.obj}" data-price="${ adding.price }">${ adding.name }</option>`);
                    if(current_order_addings !== null){
                        if(current_order_addings.hasOwnProperty('adding_standard')){
                            $('#AddingStandard').val(current_order_addings.adding_standard);
                            $form.find('.addingrow.standard').find('[name="amount[]"]').val(adult);
                            let adding  =  addings_standard.find(x=>x.obj*1 === current_order_addings.adding_standard*1 );
                            if(adding){
                                $form.find('.addingrow.standard').find('.adding-price').val(adding.price.replace(',',''));
                            }
                        }
                    }
                }
                //process not-required
                let addings_not_required = addings.filter(x=>x.required !== 'true');
                if(addings_not_required.length > 0){
                    $('.addingrow.norequired').each(function(index , item){
                        if(index > 0 ){
                            $(item).remove();
                        } else {
                            $(item).show();
                        }
                    }) ;
                    $.each(addings_not_required , function(index , adding){
                        let clone_norequired_element  = $('.addingrow.norequired').first();
                        if(index !== 0 ) {
                            clone_norequired_element  = $('.addingrow.norequired').clone();
                        }
                        clone_norequired_element.find('.adding_name').text(adding.name);
                        if((adding.obj*1) <=2){
                            let total_person = 0;
                            if(adding.obj*1 === 0){
                                total_person = adult*1+child*1+baby*1 ;
                            }
                            if(adding.obj*1 === 1){
                                total_person = child ;
                            }
                            if(adding.obj*1 === 2){
                                total_person = baby ;
                            }
                            clone_norequired_element.find('.adding-price').val(adding.price.replace(',',''));
                            clone_norequired_element.find('[name="addingtype_norequired[]"]').val(adding.name);
                            clone_norequired_element.find('[name="addingseat_norequired[]"]').val(adding.has_seat === 'true'?1:0);
                            clone_norequired_element.find('.addingobj').val(adding.obj);
                        }
                    });

                } else {
                    $('.addingrow.norequired').hide();
                }
                $.ajax({
                    url:'http://'+window.location.host+'/home/GetStartdate',
                    type: "GET",
                    data: { id : startdate_id , _token : token} ,
                    success: function(data, textStatus, jqXHR) {
                        if(data!=='fail') {
                            window['current_startdate'] =  data;
                        } else {
                            notify('Có lỗi !');
                        }
                        if(typeof calculatePrice !== 'undefined'){
                            calculatePrice();
                        }
                    }
                });
            } else {
                notify('Có lỗi !');
            }
        }
    });

}