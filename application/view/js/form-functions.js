$(init);

function init() {
    setFormListeners();
}

function setFormListeners() {
    $('input.form-control').on({
        keyup: function (e) {
            if (e.which === 27) {
                $(this).val('');
            }
            if (e.which === 13) {
//                $('#formSubmit').click();
            }
        }
    });
    $('.neo-form #formSubmit').on('click', function (e) {        
        $destin = $(this).parent().parent().attr('action');
        $postVals = $(this).parent().parent().serialize();
        sendForm($destin, $postVals);

    });
    $('.validation').on('keyup input', function () {
        $hasAddon = $type = $(this).data('addon');
        $addIcon = true;
        $formId = $(this).parent().parent().parent().attr('id');
        $id = $(this).attr('id');
        $type = $(this).data('validation');
        if ($('#' + $id)[0].tagName === 'SELECT') {
            $addIcon = false;
        }
        triggerFormSubmit($formId);
        $valid = validateField($id, $type);
        if ($valid === true) {
            addValidationSuccess($id, $hasAddon, $addIcon);
        } else {
            addValidationError($id, $hasAddon, $valid, $addIcon);
        }
    });
}

function triggerFormSubmit($formId) {
    $isValid = true;
    $validated = $('#' + $formId).children().children().children('.validation');
    $validated.each(function ($i, $el) {
        $validationResult = validateField($($el).attr('id'), $($el).data('validation'));
        if ($validationResult !== true) {
            $isValid = $validationResult;
        }
    });
    $formBtn = $('#' + $formId + ' #formSubmit');
    if ($isValid === true) {
        $formBtn.prop('disabled', false);
        $('.submit-disabled').prop('title', '');
        $formBtn.removeClass('submit-disabled');

    } else {
        $formBtn.prop('disabled', true);
        $formBtn.addClass('submit-disabled');
        $('.submit-disabled').prop('title', 'Fill in the form first');
    }
}

function validateField($fieldId, $type) {
    switch ($type) {
        case 'req' :
            return validateEmpty($fieldId);
        case 'mail' :
            return validateEmail($fieldId);
        case 'select' :
            return validateSelect($fieldId);
        default :
            console.log('could not switch ' + $type);
    }
}

function validateEmpty($fieldId) {
    $val = $('#' + $fieldId).val();
    if ($val.trim()) {
        return true;
    }
    return 'This is a required field and can not be empty';
}

function addValidationError($fieldId, $isAddon, $msg, $addIcon) {
    $par = $('#' + $fieldId).parent();
    if ($isAddon) {
        $par = $($par).parent();
    }
    if ($par.hasClass('has-success')) {
        $par.removeClass('has-success');
        $par.children('span').remove();
    }
    if (!$par.hasClass('has-error')) {
        $par.addClass('has-error');
        $html = '';
        if ($addIcon) {
            $html = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>';
        }
        $html += '<span id="' + $fieldId + 'Error" class="sr-only">(error)</span>';
        $html += '<span class="text-danger">' + $msg + '</span>';
        $par.append($html);
    }
}

function addValidationSuccess($fieldId, $isAddon, $addIcon) {
    $par = $('#' + $fieldId).parent();
    if ($isAddon) {
        $par = $($par).parent();
    }
    if ($par.hasClass('has-error')) {
        $par.removeClass('has-error');
        $par.children('span').remove();

    }
    $par.addClass('has-success');
    $html = '';
    if ($addIcon) {
        $html = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>';
    }
    $html += '<span id="' + $fieldId + 'Success" class="sr-only">(success)</span>';
    $par.append($html);
}

//https://www.formget.com/email-validation-jquery-codes/
//. : Matches any single character except a new line
//+ : Matches the preceding character or repeated character.
//$ : Matches character at the end of the line.
//. : Matches only period.
//^ : Matches the beginning of a line or string.
//: Escapes a special character.
//- : Range indicator. [a-z, A-Z]
//-: Escapes a special character.(e.g. escaping - by -)
//[0-9] : It matches digital number from 0-9.
//[a-z] : It matches characters from lowercase ‘a’ to lowercase ‘z’.
//[A-Z] : It matches characters from uppercase ‘A’ to lowercase ‘Z’.
//w: Matches a word character and underscore. (a-z, A-Z, 0-9, _).
//W: Matches a non word character (%, #, @, !).
//{M, N} : Donates minimum M and maximum N value.
function validateEmail($fieldId) {
    $mail = $('#' + $fieldId).val();
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    $test = filter.test($mail);
    return $test ? $test : 'This is NOT a valid email address';
}