$(() => {

    const ajaxUrl = window.siteSettings.ajaxurl
    const $publishJobFrom = $('.publish-job-form')

    $publishJobFrom.on('click', '[data-select-item]', function () {
        const select = $(this).parents('[data-select]')
        if (!$(this).hasClass('active')) {
            const value = $(this).attr('data-key')
            select.find($('input')).attr('data-value', value)
            select.children('[data-select-value]').html(value)
        }
    })

    $publishJobFrom.on('click', 'fieldset input', function () {
        const $input = $(this)
        if ($input.hasClass('selected')) {
            $input.removeClass('selected')
        } else {
            $input.addClass('selected')
        }
    })

    $publishJobFrom.on('submit', (event) => {
        const benefits = $('input[name="post-job-benefits[]"]').map((index, item) => {
            return $(item).attr('id')
        })

        const agreements = $('input[name="post-job-send[]"]').map((index, item) => {
            return $(item).attr('id')
        })

        const $compensationRange = $('.field-prices input')
        const skills = $('.field-skills-list li').map((index, item) => {
            return $(item).attr('data-key')
        })
        let formData = new FormData();
        formData.append('action', 'create_job');
        formData.append('id', $(this).attr('id'));
        formData.append('title', $('#post-job-title').val());
        formData.append('location', $('#post-job-location').val());
        formData.append('typeId', $('#employment-type').attr('data-value'));
        formData.append('description', $('#post-job-description').val());
        formData.append('benefits', benefits);
        formData.append('compensationFrom', $($compensationRange[0]).val());
        formData.append('compensationTo', $($compensationRange[1]).val());
        formData.append('currency', $('#currency').attr('data-value'));
        formData.append('period', $('#period').attr('data-value'));
        formData.append('isCompensationIncluded', $('#post-job-commission').val());
        formData.append('street', $('#post-job-address').val());
        formData.append('skills', skills);
        formData.append('company', $('#post-job-company').val());
        formData.append('reasonsToWork', $('#post-job-why').val());
        formData.append('companyDesc', $('#post-job-company-description').val());
        formData.append('notifyMe', $('#post-job-send').val());
        formData.append('notifyEmail', $('#post-job-send-email').val());
        formData.append('agreements', agreements);

        sendAjaxRequest(formData);
        event.preventDefault()
    })

    function sendAjaxRequest(data) {
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
                console.log(data)
            },
            error: function(data, textStatus, jqXHR) {
                console.log(data)
            },
        })
    }
})