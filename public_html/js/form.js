class FormProvider {
    //generate JS Object from controls
    static BindToFormData($form) {
        let formData = new FormData();
        $.each($form.find("[name]"), function (index, control) {
            let $control = $(control);
            let name = $control.attr("name");
            let value = $control.val();

            //HTML
            if ($control.attr("data-plugin") === "summernote") {
                formData.append(name, $control.summernote().code());
            }
            //DATE AND DATETIME
            else if ($control.attr("data-type") === "date" || $control.attr("data-type") === "datetime") {
                if (value !== '' && value !== null && value !== undefined)
                    formData.append(name, DateTimeProvider.ConvertToServerDateTime(value));
                else {
                    formData.append(name, null);
                }
            }
            //NUMBER
            else if ($control.attr("data-input-type") === "number") {
                if (value !== '' && value !== null && value !== undefined) {
                    formData.append(name, value.replace(/\,/g, ""));
                } else {
                    formData.append(name, value);
                }
            }
            //CHECKBOX
            else if ($control.attr("type") === 'checkbox') {
                formData.append(name, $control.prop('checked'));
            }
            //FILE(IMAGE AND FILE)
            else if ($control.attr("data-file") === "1") {
                let files = $control[0].files;
                if (files.length > 0 && files[0] !== undefined) {
                    formData.append(name, files[0]);
                }
            }
            //FILES(IMAGES AND FILES)
            else if ($control.attr("data-file") === "2") {
                let gStoredFile = gStoredFiles[name];
                if (gStoredFile !== undefined) {
                    $.each(gStoredFile, function (index, file) {
                        formData.append(name + "[" + index + "]", file);
                    });
                }
            }
            else if ($control.attr("data-selector") === "cms-files-value" || $control.attr("data-selector") === "cms-images-value") {
                if (value !== null) {
                    $.each(JSON.parse(value), function (index, attachmentId) {
                        formData.append(name + "[" + index + "]", attachmentId);
                    });
                }
            }
            //TEXTBOX, SELECT OR MULTIPLE SELECT
            else {
                if ($control.is("select") && $control.attr("multiple") === "multiple") {
                    $.each(value, function (index, valueItem) {
                        formData.append(name + "[" + index + "]", valueItem);
                    });
                } else {
                    formData.append(name, value);
                }
            }
        });

        return formData;
    }

    //generate FormData from controls
    static BindToModel($form) {
        let result = {};
        $.each($form.find("[name]"), function (index, control) {
            let $control = $(control);
            let name = $control.attr("name");
            let value = $control.val();
            //HTML
            if ($control.attr("data-plugin") === "summernote") {
                if(name.includes('[]')){
                    if(result.hasOwnProperty(name)){
                        result[name] = [...result[name],$control.summernote().code()];
                    } else {
                        result[name] = [$control.summernote().code()];
                    }
                } else {
                    result[name] = $control.summernote().code();
                }

            }
            //DATE AND DATETIME
            else if ($control.attr("data-type") === "date" || $control.attr("data-type") === "datetime") {
                if (value !== '' && value !== null && value !== undefined)
                    if(name.includes('[]')){
                        if(result.hasOwnProperty(name)){
                            result[name] = [...result[name],DateTimeProvider.ConvertToServerDateTime(value)];
                        } else {
                            result[name] = [DateTimeProvider.ConvertToServerDateTime(value)];
                        }
                    } else {
                        result[name] = DateTimeProvider.ConvertToServerDateTime(value);
                    }
                else {
                    if(name.includes('[]')){
                        if(result.hasOwnProperty(name)){
                            result[name] = [...result[name],null];
                        } else {
                            result[name] = [null];
                        }
                    } else {
                        result[name] = null;
                    }
                }
            }
            //NUMBER
            else if ($control.attr("data-input-type") === "number") {
                if (value !== '' && value !== null && value !== undefined) {
                    if(name.includes('[]')){
                        if(result.hasOwnProperty(name)){
                            result[name] = [...result[name],value.replace(/\,/g, "")];
                        } else {
                            result[name] = [value.replace(/\,/g, "")];
                        }
                    } else {
                        result[name] = value.replace(/\,/g, "");
                    }
                } else {
                    if(name.includes('[]')){
                        if(result.hasOwnProperty(name)){
                            result[name] = [...result[name],value];
                        } else {
                            result[name] = [value];
                        }
                    } else {
                        result[name] = value;
                    }
                }
            }
            //CHECKBOX
            else if ($control.attr("type") === 'checkbox') {
                if(name.includes('[]')){
                    if(result.hasOwnProperty(name)){
                        result[name] = [...result[name],$control.prop('checked')];
                    } else {
                        result[name] = [$control.prop('checked')];
                    }

                } else {
                    result[name] = $control.prop('checked');
                }
            }
            //TEXTBOX, SELECT OR MULTIPLE SELECT
            else {
                if(name.includes('[]')){
                    if(result.hasOwnProperty(name)){
                        result[name] = [...result[name],value];
                    } else {
                        result[name] = [value];
                    }
                } else {
                    result[name] = value;
                }
            }
        });
        return result;
    }

    //bind value from model to HTML controls
    static bindToForm($form, model) {
        if (model === undefined || model === null)
            model = {};
        $.each($form.find("[name]"), function (index, control) {
            let $control = $(control);
            let name = $control.attr("name");
            let value = model[name];
            if ($control.attr("data-plugin") === "summernote") {
                $control.summernote().code(value);
            } else if ($control.is("select")) {
                if ($control.attr("multiple")) {
                    let $hiddenControlFor = $control.prev("input[type='hidden']");
                    if ($hiddenControlFor.length > 0) {
                        let value = JSON.parse($hiddenControlFor.first().val());
                        $control.val(value);
                    }
                }
                $control.change();
            }
        });
    }
    static BindValidate() {
        var $form = $("form");
        if ($form.length > 0) {
            $form.unbind();
            $form.data("validator", null);

            $.validator.unobtrusive.parse(document);
            // Re add validation with changes
            let unobtrusiveValidation = $form.data("unobtrusiveValidation");
            if (unobtrusiveValidation !== undefined) {
                $form.validate(unobtrusiveValidation.options);
            }
        }
    }

    //generate options in select HTML controls
    static GenerateSelectHTML($select, data, replace = true, emptyText, disabledEmptyText = true) {
        let optionContent;
        if (emptyText !== undefined) {
            if (disabledEmptyText) {
                optionContent = "<option value='' disabled='disabled'>" + emptyText + "</option>";
            } else {
                optionContent = "<option value=''>" + emptyText + "</option>";
            }
        }
        $.each(data, function (index, dataItem) {
            optionContent += `<option value='${dataItem.Value}'>${dataItem.Text}</option>`;
        });
        if (replace) {
            $select.html(optionContent);
        } else {
            $select.append(optionContent);
        }
    }

    static BindMultipleSelectValue($select) {
        $select.val(JSON.parse($select.prev('input').first().val()));
    }

    static BindSelectValue($select) {
        $select.val($select.prev('input').first().val());
    }

    static GetTextareCaret(el) {
        if (el.selectionStart) {
            return el.selectionStart;
        } else if (document.selection) {
            el.focus();
            var r = document.selection.createRange();
            if (r === null) {
                return 0;
            }
            var re = el.createTextRange(), rc = re.duplicate();
            re.moveToBookmark(r.getBookmark());
            rc.setEndPoint('EndToStart', re);
            return rc.text.length;
        }
        return 0;
    }

    static Inits() {
        //$('body').on("keypress", "form", function (event) {
        //    return event.keyCode !== 13;
        //});
        $('body').on('keyup', '[data-control="1"]:not(textarea)', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                let $form = $(this).parents('form');
                if ($form.length > 0) {
                    let $submitButton = $form.first().find('[data-submit="1"]');
                    if ($submitButton.length) {
                        $submitButton.first().click();
                    }
                }
            }
        });

        $('body').on('keyup', 'textarea[data-control="1"]:not(.note-codable):not([data-plugin="summernote"])', function (event) {
            if (event.keyCode === 13) {
                var content = this.value;
                var caret = FormProvider.GetTextareCaret(this);
                if (event.shiftKey) {
                    this.value = content.substring(0, caret - 1) + "\n" + content.substring(caret, content.length);
                    event.stopPropagation();
                } else {
                    this.value = content.substring(0, caret - 1) + content.substring(caret, content.length);
                    let $form = $(this).parents('form');
                    if ($form.length > 0) {
                        let $submitButton = $form.first().find('button[data-submit="1"]');
                        if ($submitButton.length) {
                            $submitButton.first().click();
                        }
                    }
                }
            }
        });
    }

    static ValidateControl($control) {
        var $validatingControl = $control;

        var controlValue = $validatingControl.val();
        let controlName = $validatingControl.attr("name");

        let labelFor = $("label[for='" + controlName + "']");
        if (labelFor.length === 0)
            return;

        let displayName = labelFor.first().text();

        var errorMessages = [];
        var hasError = false;

        //Date and DateTime
        let dateValidate = $validatingControl.attr('data-type');
        if (dateValidate === "date" || dateValidate === "datetime") {
            if (controlValue !== '' && controlValue !== null) {
                if (!DateTimeProvider.ValidateDateTime(controlValue)) {
                    hasError = true;
                    errorMessages.push(TextProvider.Get("CMS.Validation.InvalidFormat").replace("{0}", displayName));
                }
            }
        }
        if (errorMessages.length > 0) {
            var $errorMessageContainer = $validatingControl.parents(".form-group").first().find(".field-validation-valid[data-valmsg-for='" + controlName + "']").first();
            var message = errorMessages.join("<br />");
            $errorMessageContainer.html(message);
            $errorMessageContainer.addClass("field-validation-error");
            return false;
        }
        else {
            return true;
        }
    }

    static Validate($form) {
        if ($form.valid()) {
            var validatingControls = $form.find('[data-control][data-val="true"]');

            var valid = true;
            if (validatingControls.length > 0) {
                $.each(validatingControls, function (index, validatingControl) {
                    if (!FormProvider.ValidateControl($(validatingControl)))
                        valid = false;
                });
                return valid;
            }

            return true;
        } else {
            if ($form.find('.input-validation-error:visible').length > 0) {
                $form.find('.input-validation-error:visible').first().focus();
            } else {
                $form.find('input.error[type!="hidden"]').first().focus();
            }
            if ($form.find('select.select.error').length>0) {
                $form.find('select.select.error').each(function(index , ele) {
                    $(ele).parent().find('.select2-selection').addClass('error');
                });
            }
            return false;
        }
    }
}

$(function () {
    FormProvider.Inits();

    $('body').on('keyup', '[data-control="1"]:not([data-plugin="summernote"])', function () {
        FormProvider.ValidateControl($(this));
    });

    $('body').on('focusout', '[data-control="1"]:not([data-plugin="summernote"])', function () {
        FormProvider.ValidateControl($(this));
    });

    //$('body').on('change', '[data-control="1"]', function () {
    //    FormProvider.ValidateFormControl(this);
    //});
});