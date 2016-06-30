$(init);
function init() {
    setFormListeners();
}

function setFormListeners() {
    $('form').on('submit', function () {
        $('.customScroll').mCustomScrollbar("destroy");
        $('.page-loader').show();
    });
    $('#avatar-choice-trigger').on('click', function (e) {
        e.preventDefault();
        $('#avatar-choice-menu').fadeIn();
    });
    $('.avatar-chosen').on('click', function (e) {
        e.preventDefault();
        $('#avatar').val($(this).data('avatar-id'));
        $('#avatar-choice-menu').fadeOut();
        $('#avatar').parent().addClass('has-success');
        $formId = $("#avatar").parent().parent().parent().attr('id');
        console.log($formId);
        triggerFormSubmit($formId);
    });
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
    $('.validation').on('keyup input change', function () {
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
    $('.user-mail-validation').on('keyup change', function () {
        validateUserMail($(this).attr('id'));
    });
    $('.user-name-validation').on('keyup change', function () {
        validateUsername($(this).attr('id'));
    });
    $('input:file').on('change', function () {
        triggerFormSubmit($(this).parent().parent().parent().attr('id'));
    });
}

function triggerFormSubmit($formId) {
    $isValid = true;
    $validated = $('#' + $formId).children().children('.has-feedback');

    $validated.each(function ($i, $el) {
        if ($($el).hasClass('has-success') === false) {
            $isValid = false;
            console.log($el);
        }
    });
    if ($('.user-mail-validation').length) {
        $isValid = ($isValid === true && $('.user-mail-validation').parent().hasClass('has-success'));
    }
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
        case 'pwd' :
            return validatePWD($fieldId);
        case 'pwd-repeat':
            return validatePWDRepeat($fieldId);
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
function validatePWDRepeat($fieldId) {
    $pw = $('#user-pwd').val();
    $pwRep = $('#' + $fieldId).val();
    if (!$pwRep.trim()) {
        return 'Password repeat is a required field';
    }
    if ($pw === $pwRep) {
        return true;
    }
    return 'Password and password repeat do not match';
}
function validatePWD($fieldId) {
    $pw = $('#' + $fieldId).val();
    if (!$pw.trim()) {
        return 'Password is a required field';
    }
    $validationResult = '';
    $regDig = $pw.search(/\d/);
    $regLow = $pw.search(/[a-z]/);
    $regCap = $pw.search(/[A-Z]/);
    $white = $pw.search(/\s/g);
    $length = $pw.length;
    $validationResult += ($regDig === -1 ? 'Your password needs at least 1 digit<br>' : '');
    $validationResult += $regLow === -1 ? 'Your password needs at least 1 lower case character<br>' : '';
    $validationResult += $regCap === -1 ? 'Your password needs at least 1 updar case character<br>' : '';
    $validationResult += $length < 5 ? 'Your password needs a minimum of 5 characters<br>' : '';
    $validationResult += $white === -1 ? '' : 'Password can not contain white space';
    return $validationResult ? $validationResult : true;
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
    } else {
        $('#' + $fieldId + 'Error').next().html($msg);
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

function validateUserMail($fieldId) {
    $mail = $('#' + $fieldId).val();
    if (validateEmail($fieldId) !== true) {
        addValidationError($fieldId, false, 'This is NOT a valid email address', true);
        triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
    } else {
        $.get('user/checkEmail/' + $mail, function ($data) {
            if ($data === 'valid') {
                addValidationSuccess($fieldId, false, true);
                triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
            } else {
                addValidationError($fieldId, false, 'This email address is already in use', true);
                triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
            }
        });
    }
}

function validateUsername($fieldId) {
    $username = $('#' + $fieldId).val();
    if (validateEmpty($fieldId) !== true) {
        addValidationError($fieldId, false, 'This is a required field!', true);
        triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
    } else if ($username.indexOf(' ') >= 0) {
        addValidationError($fieldId, false, 'Username can not contain white space', true);
        triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
    } else {
        $.get('user/checkUsername/' + $username, function ($data) {
            if ($data === 'valid') {
                addValidationSuccess($fieldId, false, true);
                triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
            } else {
                addValidationError($fieldId, false, 'This username is already in use', true);
                triggerFormSubmit($('#' + $fieldId).parent().parent().parent().attr('id'));
            }
        });
    }
}

//$valid = validateField($id, $type);
//        if ($valid === true) {
//            addValidationSuccess($id, $hasAddon, $addIcon);
//        } else {
//            addValidationError($id, $hasAddon, $valid, $addIcon);
//        }