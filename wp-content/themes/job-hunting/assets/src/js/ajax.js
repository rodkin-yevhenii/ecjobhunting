$(() => {

    const ajaxUrl = window.siteSettings.ajaxurl
    const $publishJobFrom = $('.publish-job-form')
    const $duplicateJobFrom = $('.duplicate-job-form')

    const $vacancyHolder = $('.js-vacancies')
    const $loadMoreBtn = $('.js-load-more')

    function postJobAjax(data, $messageContainer) {
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response && response.status === 201) {
                    $($messageContainer).removeClass('is-error')
                    $($messageContainer).html(response.message)
                    setTimeout(() => {
                        window.location.replace(response.permalink)
                    }, 3000)
                } else if (response.status === 404 || response.status === 401) {
                    $($messageContainer).html(response.message)
                    $($messageContainer).addClass('is-error')
                } else {
                    $($messageContainer).addClass('is-error')
                    $($messageContainer).html('Something went wrong, try again')
                }
            }
        })
    }

    function loadMoreAjax($holder, $btn) {
        let paged = $holder.attr('data-paged')
        const postType = $holder.attr('data-posttype')
        const perPage = $holder.attr('data-perpage')
        const offset = perPage * paged
        const data = {
            action: 'load_more',
            post_type: postType,
            post_status: 'publish',
            per_page: perPage,
            offset: offset
        }
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.html) {
                    $holder.append(response.html)
                }
                const shown = Number(offset) + Number(response.itemsCount)
                $holder.attr('data-paged', ++paged)
                $holder.attr('data-shown', shown)
                if (Number(response.total) <= shown) {
                    $btn.fadeOut();
                }
            }
        })
    }

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

    $duplicateJobFrom.on('submit', (event) => {
        event.preventDefault()
        const postId = $('#post-job-title-duplicate').val()
        const author = $duplicateJobFrom.attr('data-author');
        const submitBtn = $duplicateJobFrom.find('button[type="submit"]')

        let formData = new FormData();
        formData.append('action', 'duplicate_job')
        formData.append('postId', postId || 0)
        formData.append('author', author || '')

        postJobAjax(formData, submitBtn);
    })

    $publishJobFrom.on('submit', (event) => {
        event.preventDefault()
        const submitBtn = $publishJobFrom.find("button[type=submit]:focus")

        let benefits = [];
        let agreements = [];
        let skills = [];
        $('input[name="post-job-benefits[]"]:checked').each((index, item) => {
            benefits.push($(item).attr('id'))
        })

        $('input[name="post-job-send[]"]:checked').each((index, item) => {
            agreements.push($(item).attr('id'))
        })

        const $compensationRange = $('.field-prices input')
        $('.field-skills-list li').each((index, item) => {
            skills.push($(item).attr('data-key'))
        })
        let formData = new FormData();
        formData.append('action', 'create_job');
        formData.append('id', $(this).attr('id'));
        formData.append('status', $(submitBtn).attr('data-status')) || 'draft';
        formData.append('title', $('#post-job-title').val());
        formData.append('location', $('#post-job-location').val());
        formData.append('typeId', $('#employment-type').attr('data-value'));
        formData.append('description', $('#post-job-description').val());
        formData.append('benefits', benefits);
        formData.append('compensationFrom', $($compensationRange[0]).val());
        formData.append('compensationTo', $($compensationRange[1]).val());
        formData.append('currency', $('#currency').attr('data-value') || 'USD');
        formData.append('period', $('#period').attr('data-value') || 'annualy');
        formData.append('isCommissionIncluded', $('#post-job-commission').val());
        formData.append('street', $('#post-job-address').val());
        formData.append('skills', skills);
        formData.append('company', $('#post-job-company').val());
        formData.append('reasonsToWork', $('#post-job-why').val());
        formData.append('companyDesc', $('#post-job-company-description').val());
        formData.append('notifyMe', $('#post-job-send').val());
        formData.append('notifyEmail', $('#post-job-send-email').val());
        formData.append('agreements', agreements);
        formData.append('author', $publishJobFrom.attr('data-author'));

        postJobAjax(formData, submitBtn);
    })

    $loadMoreBtn.on('click', (e) => {
        const total = $vacancyHolder.attr('data-total')
        const itemsShown = $vacancyHolder.attr('data-shown')
        if (total <= itemsShown) {
            $btn.fadeOut();
        }
        loadMoreAjax($vacancyHolder, $loadMoreBtn)
    })
})